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

        //$service = new \Google_Service_Sheets($client);


        $sheet_id = '1DRe3JKouPvmXoosZXlhXcNOGnALHO61J39QTItwAMHc';
        $valueInputOption = "USER_ENTERED";
        $ship_date = '2020-09-30';
        $order_indexes = OrderItem::AutoDeliveryIndex($ship_date)->get();
        $range = 'B2:M200';

        //$shipment_lists = Inventory::ShipmentList($order_indexes)->post();

        $order_items = array();
     
        foreach ( $order_indexes as $order) {

            array_push($order_items, [
                $order->order->transport_id,
                $order->order->transportCompany->name,
                $order->order->transportCompany->stuff_name,
                $order->order->delivery_user_id,
                $order->order->clientCompanyDeliveryUser->name
                ]);
        }
        $data = new \Google_Service_Sheets_ValueRange();
        $data->setValues([
                'range' => $range, 
                'values' => $order_items
            ]);

        $body = new \Google_Service_Sheets_BatchUpdateValuesRequest(array(
            'valueInputOption' => $valueInputOption,
            'data' => $data
        ));
        $result = $sheets->spreadsheets_values->batchUpdate($sheet_id, $body);


            /*$params = ['valueInputOption' => 'USER_ENTERED'];
            $sheets->spreadsheets_values->batchUpdate(
                $sheet_id,
                'A2',
                $values,
                $params
            );*/
    }
}
