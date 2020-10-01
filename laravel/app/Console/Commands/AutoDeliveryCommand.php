<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderItem;
use App\Models\Inventory;
use App\Models\GoogleSheet;
use Carbon\Carbon;

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

        $sheet_id = \Config::get('const.Account.spread_sheet_id');
        //$sheet_id = '1DRe3JKouPvmXoosZXlhXcNOGnALHO61J39QTItwAMHc';
        $valueInputOption = "USER_ENTERED";
        $ship_date = '2020-09-16';
        $range = 'A2';

        //dd($sheet_id);
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        foreach ($order_indexes as $order) {

            $shipment_sum = 0;

            while ($shipment_sum <= $order->quantity) {

                $inventory = Inventory::SearchByShipDate($order)->first();

                    //$inventory nullの場合はブレイクにする
                    if (empty($inventory)) {
                        dd($shipment_sum);//テスト段階では仮で0であることを返す
                        return ;//"在庫が不足していおります。注文を減らすか、在庫を増やして下さい」と通知したい"
                        
                    }

                $ship_arranged = \Config::get('const.Temporaries.ship_arranged');
                $inventory->order_item_id = $order->id;
                $inventory->ship_date = $order->ship_date;
                $inventory->status = $ship_arranged;
                $inventory->save();

                $shipment_sum = Inventory::where('inventories.order_item_id', $order->id)
                    ->where('inventories.ship_date', $order->ship_date)
                    ->sum('inventories.weight');
            }

        }

        $ship_arranged_list = Inventory::SearchByShipArrangedList($ship_date)->get();

        $order_items = array();
     
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

        $body = new \Google_Service_Sheets_BatchUpdateValuesRequest(array(
            'valueInputOption' => $valueInputOption,
            'data' => $data
        ));
        $result = $sheets->spreadsheets_values->batchUpdate($sheet_id, $body);

    }
}
