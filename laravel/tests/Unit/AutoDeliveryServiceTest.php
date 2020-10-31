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
use Mockery;

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
        //注文が足りないパターン
        $order_indexes1 = [];

        $order_indexes1[] = factory(OrderItem::class, 'test_order_mock_date_1')->make()->toArray();

        array_push($order_indexes1, 'done_flag');

        dd($order_indexes1);
        //$order_indexes1 = ['ship_date' => '2020-01-01'];
        //$ship_date1 = $order_indexes1->pluck('ship_date')->toArray();
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        Mail::fake();
        $mock1 = AutoDeliveryService::DeliveryExecute($ship_date, $order_indexes);
        Mail::assertSent(AutoDeliverySystemNotification::class, 1);
        $this->assertSame($mock1, '在庫無し');


        /*//注文が足りているパターン　TODO後から実装
        $order_indexes2 = [];

        $order_indexes2[] = factory(OrderItem::class, 'test_order_mock_date_2')->make()->toArray();
        $ship_date = $this->AutoDeliveryService->pluck();

        dd($ship_date);
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        Mail::fake();
        $mock2 = AutoDeliveryService::DeliveryExecute($ship_date, $order_indexes);
        
        $done_flag = $mock2->pluck('done_flag')->toArray();
        Mail::assertSent(AutoDeliverySystemNotification::class, 1);
        $this->assertSame($done_flag, true);*/
    }
}
