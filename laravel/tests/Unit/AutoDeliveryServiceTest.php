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
        $order_indexes = [];

        $ship_date = '2020-01-11'; 

        $order_indexes[] = factory(OrderItem::class, 'test_order_mock_date_1')->make([
                                'done_flag' => false,
                                'weight' => 200000,
                                'ship_date' => $ship_date
                                ])->toArray();

        $target = $this->getMockBuilder(AutoDeliveryService::class)
                        ->setMethods(['DeliveryExecute'])
                        ->getMock();

        $target->expects($this->once())
                ->method('DeliveryExecute')
                ->will($this->callback(function($ship_date, $order_indexes) {
                    return is_callable($lost_point);
                }));

        Mail::fake();

        $target->DeliveryExecute($ship_date, $order_indexes);

        $this->assertNotNull($lost_point);

        Mail::assertSent(AutoDeliverySystemNotification::class, 1);

        /*作成中

        $checkerMock = Mockery::mock('deliveryExecuteChecker');
        $checkerMock
            ->shouldReceive('checkDeliveryExecute')
            ->with('foo')
            ->andReturn($lost_point);

        $factoryMock = Mockery::mock('overload:CheckerFactory');
        $factoryMock ->shouldReceive('make')->andReturn($lost_point);*/

        

        //　動作NG $ship_date = date('y/m/d', strtotime($order_indexes[0]['ship_date']));

        //dd($ship_date);
        //$ship_date1 = $order_indexes1->pluck('ship_date')->toArray();


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
