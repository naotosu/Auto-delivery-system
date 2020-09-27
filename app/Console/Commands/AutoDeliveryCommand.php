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
        $ship_date = '2020-09-30';
        $order_indexes = OrderItem::AutoDeliveryIndex($ship_date);

        $order_items = array(
            foreach ($order_indexes as $order) {
            
                $order->item_code,/* ←テスト書き込み
                <td>{{$order->item->name}}</td>
                <td>{{$order->ship_date}}</td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->name}}（仮）</td>
                <td>{{$order->name}}（仮）</td>
                <td>{{$order->order->delivery_user_id}}</td>
                <td>{{$order->order->clientCompanyDeliveryUser->name}}</td>
                <td>{{$order->temporary_flag]*/                
            }
        );

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
        );
    }
}
