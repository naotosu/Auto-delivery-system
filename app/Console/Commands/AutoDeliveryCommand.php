<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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

class AutoDeliveryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auto_delivery {ship_date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sheets = GoogleSheet::InitializeClient();

        $sheet_id = \Config::get('const.Constant.spread_sheet_id');
        $acceptable_range = \Config::get('const.Constant.acceptable_range');
        $valueInputOption = "USER_ENTERED";
        $ship_date = $this->argument("ship_date");
        $range = $ship_date.'!'.'A1';
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        $order_info = $order_indexes->pluck('ship_date')->toArray();

        if (empty($order_info)) {
            $users = User::all();
            $users_mail_lists = $users->pluck('email')->toArray();

            $transports = TransportCompany::all();
            $transport_mail_lists = $transports->pluck('email')->toArray();
                  
            $mail_lists = array_merge($users_mail_lists, $transport_mail_lists);
            $mail_text = '注文日'.$ship_date.'この日の新しい注文はございません。
            　※別途送付済みの指示書がある場合は、そちらを正としてご手配を進めて下さい。';
            Mail::to($mail_lists)->send( new AutoDeliverySystemNotification($mail_text) );
            return ;
        }

        DB::beginTransaction();
        try {

            foreach ($order_indexes as $order_item) {

                $shipment_sum = 0;
                $order_sum = $order_item->weight - $acceptable_range;
                $inventories = Inventory::SearchByItemCodeAndStatus($order_item)->get();
                $cntend = count($inventories);
                $cnt = 0;

                foreach($inventories as $inventory) {
                
                    $shipment_sum = $shipment_sum + $inventory->weight;
                    $ship_arranged = \Config::get('const.Constant.ship_arranged');
                    $inventory->order_item_id = $order_item->id;
                    $inventory->order_id = $order_item->order_id;
                    $inventory->ship_date = $order_item->ship_date;
                    $inventory->status = $ship_arranged;
                    $inventory->save();

                    if ($order_sum <= $shipment_sum){
                        $order_item->done_flag = 1;
                        $order_item->save();
                        break;
                    }

                    $cnt++;

                    if ($cnt == $cntend) {
                        $lost_point = $inventory->order_code;
                        throw new Exception($lost_point);
                        //　TODO 必要に応じ配列化し、複数のエラーを表示する可能性有り
                    }
                }
            }
        
            $ship_arranged_list = Inventory::SearchByShipArrangedList($ship_date)->get();
            //TODO 臨時出荷（CSV出力）終わった明細も再出力している。このままで良いか別途検討（このままの方が親切かも）

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

            $mail_text = '新しい指示書が更新されました。輸送会社様はご確認をお願い致します。';
            Mail::to($mail_lists)->send( new AutoDeliverySystemNotification($mail_text) );

            DB::commit();
        
        } catch (\Exception $e) {
            $users = User::all();
            $users_mail_lists = $users->pluck('email')->toArray();

            $transports = TransportCompany::all();
            $transport_mail_lists = $transports->pluck('email')->toArray();
                  
            $mail_lists = array_merge($users_mail_lists, $transport_mail_lists);

            $mail_text = '指示書の作成を中断しました。在庫が足りていない可能性があります。item_code[ '.$e->getMessage().' ]で不足';
            $inventory_error = Mail::to($mail_lists)->send( new AutoDeliverySystemNotification($mail_text) );
            return DB::rollback();
        }
    }
}
