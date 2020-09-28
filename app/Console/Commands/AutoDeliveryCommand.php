<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderItem;
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

        $sheet_id = '1DRe3JKouPvmXoosZXlhXcNOGnALHO61J39QTItwAMHc';
        $ship_date = '2020-09-29';
        $order_indexes = OrderItem::AutoDeliveryIndex($ship_date)->get();

        $shipment_lists = Inventory::ShipmentList($order_indexes)->post();

        $order_items = array();
        $x = 0;
     
        foreach ( $order_indexes as $order) {

            //$order_items　=  [array_merge($order->order->transport_id)];

            array_push($order_items, [
                $order->order->transport_id,
                $order->order->transportCompany->name,
                $order->order->transportCompany->stuff_name,
                $order->order->delivery_user_id,
                $order->order->clientCompanyDeliveryUser->name
                ]);

            $x++;
        }

        for ($i = 0; $i < $x; $i++ ) {
            $values = new \Google_Service_Sheets_ValueRange();
            $values->setValues([
                'values' => $order_items[$i]
            ]);
            $params = ['valueInputOption' => 'USER_ENTERED'];
            $sheets->spreadsheets_values->append(
                $sheet_id,
                'A2',
                $values,
                $params
            );

        }

  //          array_push($order_items, [$order->order->transport_id, $order->order->transportCompany->name]);
            //array_push($order_items, $order->order->transportCompany->name);

            /*array_push($order_items, $order->order->transport_id);
            array_push($order_items, $order->order->transportCompany->name);
            array_push($order_items, $order->order->transportCompany->stuff_name);
            array_push($order_items, $order->order->delivery_user_id);
            array_push($order_items, $order->order->clientCompanyDeliveryUser->name);
            array_push($order_items, $order->order_code);
            array_push($order_items, $order->item->name);

            


             /*           
                        $temporary->,
                        $temporary->, 
                        $temporary->,
                        $temporary->item->name,
                        $temporary->item->size, 
                        $temporary->item->shape, 
                        $temporary->item->spec,
                        $temporary->ship_date,
                        $temporary->charge_code,
                        $temporary->manufacturing_code,
                        $temporary->bundle_number,
                        $temporary->weight,
                        $temporary->quantity,
        
                /*$order->item_code,
                <td>{{$order->item->name}}</td>
                <td>{{$order->ship_date}}</td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->name}}（仮）</td>
                <td>{{$order->name}}（仮）</td>
                <td>{{$order->order->delivery_user_id}}</td>
                <td>{{$order->order->clientCompanyDeliveryUser->name}}</td>
                <td>{{$order->temporary_flag]*/
        //}

/*$test_array  = [
    ['a', 'b', 'c'],
    ['d', 'e', 'f'],
    ['g', 'h', 'i']
];

dd($test_array);

        $values = new \Google_Service_Sheets_ValueRange();
        $values->setValues([
            'values' => $order_items
        ]);
        $params = ['valueInputOption' => 'USER_ENTERED'];
        $sheets->spreadsheets_values->append(
            $sheet_id,
            'A2',
            $values,
            $params
        );*/
    }
}
