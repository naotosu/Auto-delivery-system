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
use \Mockery;
use \Exception;
use \ErrorException;

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


    /**
     * @test
     * @expectedException ErrorException
     * @expectedExceptionMessage 在庫無し
     */
    public function testTryOrderItemsAndInventories()
    {
        //在庫が一つも無いパターン
        $ship_date = '2020-01-01'; 
        $order_item = factory(OrderItem::class, 'test_order_mock_date_1')->make([
                                'item_code' => 'test111',
                                'ship_date' => $ship_date
                                ]);

        $this->expectException(ErrorException::class);
        $this->expectExceptionMessage("在庫無し");

        AutoDeliveryService::TryOrderItemsAndInventories($order_item);

        //注文が足りないパターン

        /*$ship_date = '2020-01-01'; 

        $order_item = factory(OrderItem::class, 'test_order_mock_date_1')->make([
                                'done_flag' => false,
                                'weight' => 2000000,
                                'ship_date' => $ship_date
                                ]);

        AutoDeliveryService::TryOrderItemsAndInventories($order_item);



        //注文が足りているパターン　TODO後から実装

        $ship_date = '2020-01-01';

        $order_item = factory(OrderItem::class, 'test_order_mock_date_1')->make([
                                'done_flag' => false,
                                'ship_date' => $ship_date
                                ]);

        $target = $this->getMockBuilder(AutoDeliveryService::class)
                        ->setMethods(['DeliveryExecute'])
                        ->getMock();

        $order_item = AutoDeliveryService::TryOrderItemsAndInventories($order_item);
        $this->assertSame($order_item->pluck('done_flag')->toArray(), true);*/
    }
}
