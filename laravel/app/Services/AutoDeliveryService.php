<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\Inventory;
use App\Services\GoogleSheet;
use App\Models\TransportCompany;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use \Exception;
use App\Mail\AutoDeliverySystemNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AutoDeliveryService
{
    public static function NoOrderSendMail($ship_date)
    {
        $users = User::all();
        $users_mail_lists = $users->pluck('email')->toArray();
        $transports = TransportCompany::all();
        $transport_mail_lists = $transports->pluck('email')->toArray();

        $mail_lists = array_merge($users_mail_lists, $transport_mail_lists);
        $mail_text = '納入日'.$ship_date.'この日の新しい注文はございません。
        　※別途送付済みの指示書がある場合は、そちらを正としてご手配を進めて下さい。';
        Mail::to($mail_lists)->send( new AutoDeliverySystemNotification($mail_text) );
    }

    public function pushGoogleSheet()
    {
        //後ほど移動予定
    }

    public static function TryOrderItemsAndInventories($order_item)
    {
        $inventories = Inventory::SearchByItemCodeAndStatus($order_item)->get();

        if(count($inventories) == 0) {
            throw new Exception("在庫全く無し");
        }

        $acceptable_range = \Config::get('const.Constant.acceptable_range');
        $ship_arranged = \Config::get('const.Constant.ship_arranged');

        $shipment_sum = 0;
        $order_sum = $order_item->weight - $acceptable_range;

        foreach($inventories as $inventory) {
        
            $shipment_sum = $shipment_sum + $inventory->weight;
            $inventory->order_item_id = $order_item->id;
            $inventory->order_id = $order_item->order_id;
            $inventory->ship_date = $order_item->ship_date;
            $inventory->status = $ship_arranged;
            $inventory->save();

            if ($order_sum <= $shipment_sum){
                $order_item->done_flag = true;
                $order_item->save();
                return $order_item;
            }
        }

        $lost_point = $inventory->order_code;
        throw new Exception('オーダーcode [ '.$lost_point.' ]で不足');
        //　TODO 必要に応じ配列化し、複数のエラーを表示する可能性有り    
    }

    public static function DeliveryExecute($ship_date, $order_indexes)
    {
        $sheets = GoogleSheet::InitializeClient();

        $sheet_id = \Config::get('const.Constant.spread_sheet_id');
        $valueInputOption = "USER_ENTERED";
        $range = $ship_date.'!'.'A1';

        $order_indexes = $order_indexes->where('done_flag', false);

        DB::beginTransaction();
        try {

            foreach ($order_indexes as $order_item) {                
                AutoDeliveryService::TryOrderItemsAndInventories($order_item);
            }

            $ship_arranged_list = Inventory::SearchByShipArrangedList($ship_date)->get();
            //臨時出荷（CSV出力）終わった明細も再出力している。

            $order_items = array();

            array_push($order_items, [
                    '配送業者ID',
                    '配送業者',
                    '担当',
                    '納品先コード',
                    '納品先',
                    'オーダーCode',
                    '鋼種', 
                    'サイズ', 
                    '単位',
                    '仕様',
                    '納入日',
                    'チャージ',
                    '製造No',
                    '束番',
                    '重量',
                    '本数',
                    ]);
         
            foreach ( $ship_arranged_list as $order) {

                array_push($order_items, [
                    $order->order->transport_id,
                    $order->order->transportCompany->name,
                    $order->order->transportCompany->stuff_name,
                    $order->order->delivery_user_id,
                    $order->order->clientCompanyDeliveryUser->name,
                    $order->order_code,
                    $order->item->name,
                    $order->item->size, 
                    $order->item->shape, 
                    $order->item->spec,
                    $order->ship_date,
                    $order->charge_code,
                    $order->manufacturing_code,
                    $order->bundle_number,
                    $order->weight,
                    $order->quantity,
                    ]);
            }
         

            $response = $sheets->spreadsheets->get($sheet_id);
            $sheet_lists = $response->getSheets();

            foreach ($sheet_lists as $sheet) {

                $properties = $sheet->getProperties();
                $sheet_id_info = $properties->getSheetId();
                $sheet_title = $properties->getTitle();

                if ($sheet_title == $ship_date) {
                    $delete_sheet = $sheet_id_info;
                }

            }

            if (isset($delete_sheet)) {

                $body = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
                    'requests' => [
                        'deleteSheet' => [
                            'sheetId' => $delete_sheet
                        ]
                    ]
                ]);

                $response = $sheets->spreadsheets->batchUpdate($sheet_id, $body);
            }

            $data = [];
            $data[] = new \Google_Service_Sheets_ValueRange(array(
                'range' => $range,
                'values' => $order_items
            ));

            $body = new \Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
                'requests' => array('addSheet' => array('properties' => array('title' => $ship_date)))
            )); 

            $response = $sheets->spreadsheets->batchUpdate($sheet_id, $body);
            $new_sheet_id = $response->getReplies()[0]
                ->getAddSheet()
                ->getProperties()
                ->sheetId;

            $body = new \Google_Service_Sheets_BatchUpdateValuesRequest(array(
                'valueInputOption' => $valueInputOption,
                'data' => $data
            ));

            $result = $sheets->spreadsheets_values->batchUpdate($sheet_id, $body);

            $users = User::all();
            $users_mail_lists = $users->pluck('email')->toArray();

            $transports = TransportCompany::all();
            $transport_mail_lists = $transports->pluck('email')->toArray();
                  
            $mail_lists = array_merge($users_mail_lists, $transport_mail_lists);

            $mail_text = '納入日'.$ship_date.'分の新しい指示書が更新されました。輸送会社様はご確認をお願い致します。';
            Mail::to($mail_lists)->send( new AutoDeliverySystemNotification($mail_text) );

            DB::commit();
        
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $users = User::all();
            $users_mail_lists = $users->pluck('email')->toArray();

            $transports = TransportCompany::all();
            $transport_mail_lists = $transports->pluck('email')->toArray();
                  
            $mail_lists = array_merge($users_mail_lists, $transport_mail_lists);

            $mail_text = '納入日'.$ship_date.'指示書の作成を中断しました。在庫が足りていない可能性があります。'.$e->getMessage();
            Mail::to($mail_lists)->send( new AutoDeliverySystemNotification($mail_text) );
            return DB::rollback();
        }
    }
}
