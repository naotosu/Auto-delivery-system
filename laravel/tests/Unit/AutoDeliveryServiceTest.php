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
        //注文が足りないパターン
        $ship_date = "2020-11-05";
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        Mail::fake();
        $mock1 = AutoDeliveryService::DeliveryExecute($ship_date, $order_indexes);
        Mail::assertSent(AutoDeliverySystemNotification::class, 1);
        $this->assertSame($mock1, '在庫無し');


        //注文が足りているパターン
        $ship_date = "2020-09-18";
        
        $order_indexes = OrderItem::SearchByShipDate($ship_date)->get();

        Mail::fake();
        $mock2 = AutoDeliveryService::DeliveryExecute($ship_date, $order_indexes);
        //dd($mock2); ←注文無しパターンがreturnされている
        
        $done_flag = $mock2->pluck('done_flag')->toArray();
        Mail::assertSent(AutoDeliverySystemNotification::class, 1);
        $this->assertSame($done_flag, true);
    }
}
