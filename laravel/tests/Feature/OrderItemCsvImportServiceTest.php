<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\OrderItemCsvImportService;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use SplFileObject;

class OrderItemCsvImportServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testOrderItemCsvImport()
    {
        $order_item = new OrderItemCsvImportService();

        DB::beginTransaction();
        $order_item = OrderItem::insert(array(
                                'order_id' => 1,
                                'item_code' => "BB1",
                                'ship_date' => '2020-01-01',
                                'weight' => 1111,
                            ));

        dd($order_item); //trueが返ってくる

        $order_item->assertEquals(1, $result[0]['order_id']);
        $order_item->assertEquals("BB1", $result[1]['item_code']);

    }
}
