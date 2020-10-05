<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderItem;
use App\Models\Inventory;
use App\Models\GoogleSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use \Exception;

class AutoDeliveryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auto_delivery';

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
        $sheets = GoogleSheet::OrderItem();

        $sheet_id = \Config::get('const.Constant.spread_sheet_id');
        $acceptable_range = \Config::get('const.Constant.acceptable_range');
        $valueInputOption = "USER_ENTERED";
        $ship_date = '2020-9-17';
        $range = $ship_date.'!'.'A1';
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        DB::beginTransaction();
        try {

            foreach ($order_indexes as $order_item) {

                $shipment_sum = 0;
                $order_sum = $order_item->quantity - $acceptable_range;
                $inventories = Inventory::SearchByItemCodeAndStatus($order_item)->get();
                $cntend = count($inventories);
                $cnt = 0;

                foreach($inventories as $inventory) {
                
                    $shipment_sum = $shipment_sum + $inventory->weight;
                    $ship_arranged = \Config::get('const.Constant.ship_arranged');
                    $inventory->order_item_id = $order_item->id;
                    $inventory->ship_date = $order_item->ship_date;
                    $inventory->status = $ship_arranged;
                    $inventory->save();

                    if ($order_sum <= $shipment_sum){
                        break;
                    }

                    $cnt++;

                    if ($cnt == $cntend) {
                        throw new Exception('在庫不足');
                        // TODO: "在庫が不足していおります。注文を減らすか、在庫を増やして下さい」と通知したい"
                    }
                }
            }
        
            $ship_arranged_list = Inventory::SearchByShipArrangedList($ship_date)->get();

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

            $data = [];
            $data[] = new \Google_Service_Sheets_ValueRange(array(
                'range' => $range,
                'values' => $order_items
            ));

            // TODO: 更新失敗シートが残ってた場合は消去するコードを後程作成

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

            DB::commit();
        
        } catch (\Exception $e) {
            return DB::rollback();
        }

    }
}
