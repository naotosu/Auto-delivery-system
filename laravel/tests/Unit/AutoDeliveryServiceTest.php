<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\AutoDeliveryService;
use App\Models\OrderItem;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AutoDeliverySystemNotification;
use Illuminate\Support\Facades\DB;

class AutoDeliveryServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoOrderSendMail()
    {
        Mail::fake();
        $now = Carbon::now();
        $ship_date = date('y/m/d', strtotime($now));
        AutoDeliveryService::NoOrderSendMail($ship_date);
        Mail::assertSent(AutoDeliverySystemNotification::class, 1);
    }

    public function testDeliveryExecute()
    {
        DB::beginTransaction();

        //注文が足りないパターン
        $ship_date = "2020-11-05";
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        $order_info = $order_indexes->pluck('ship_date')->toArray();

        Mail::fake();
        AutoDeliveryService::DeliveryExecute($ship_date, $order_indexes);
        Mail::assertSent(AutoDeliverySystemNotification::class, 1);

        //注文が足りているパターン
        $ship_date = "2020-09-17";
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        $order_info = $order_indexes->pluck('ship_date')->toArray();

        Mail::fake();
        AutoDeliveryService::DeliveryExecute($ship_date, $order_indexes);
        $order_tests = OrderItem::SearchByShipDate($ship_date)->get();
        dd($order_tests);
        //assertEquals($order_tests->pluck('done_flag'), true);

        $query = null;
        $item_code = null;
        $order_id = null;
        $order_start = $ship_date;
        $order_end = $ship_date;
        $status = \Config::get('const.Constant.ship_arranged');

        $inventory_tests = Inventory::SearchByStock($query, $item_code, $order_id, $order_start, $order_end, $status)->get();
        //dd($inventory_tests);
        $inventory_item_code = $inventory_tests->pluck('item_code');
        $order_tests = $order_tests->pluck('item_code');
        assertEquals($inventory_item_code, $order_tests);

        Mail::assertSent(AutoDeliverySystemNotification::class, 1);
        DB::rollback();
    }
}
