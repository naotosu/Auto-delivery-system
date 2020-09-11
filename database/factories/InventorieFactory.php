<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Item;

$factory->define(App\Inventorie::class, function (Faker $faker) {
    return [
            'order_number' => Str::random(7),
            'charge_number' => Str::random(4),
            'manufacturing_number' => Str::random(8),
            'bundle_number' => "01",
            'weight' => "2000",
            'quantity' => "18",
            'status' => "3",
            'production_date' => "2020-08-29",
            'factory_warehousing_date' => "2020-08-30",
            'warehouse_receipt_date' => "2020-08-31",
            'input_user_id' => "1",
            'item_id' => function() {
            	return Item::all()->random()->item_id;
            } // 22111111150　22111111255　22111111363　3パターン
    ];
});
