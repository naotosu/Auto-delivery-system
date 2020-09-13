<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Item;

$factory->define(App\Inventory::class, function (Faker $faker) {
    return [
            'order_code' => Str::random(7),
            'charge_code' => Str::random(4),
            'manufacturing_code' => Str::random(8),
            'bundle_number' => "01",
            'weight' => "2000",
            'quantity' => "18",
            'status' => "3",
            'production_date' => $faker->dateTimeBetween('2020-8-25', '2020-08-27'),
            'factory_warehousing_date' => $faker->dateTimeBetween('2020-08-28', '2020-08-29'),
            'warehouse_receipt_date' => $faker->dateTimeBetween('2020-08-30', '2020-08-31'),
            'input_user_id' => "1",
            'item_code' => function() {
            	return Item::all()->random()->item_code;
            } // 22111111150　22111111255　22111111363　3パターン
    ];
});
