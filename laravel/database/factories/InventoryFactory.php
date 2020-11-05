<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Item;

$factory->define(App\Models\Inventory::class, function (Faker $faker) {
    return [
            'order_code' => Str::random(7),
            'charge_code' => Str::random(5),
            'manufacturing_code' => Str::random(8),
            'bundle_number' => "01",
            'weight' => $faker->numberBetween($min = 1900, $max = 2100),
            'quantity' => "18",
            'status' => $faker->numberBetween($min = 2, $max = 3),
            'production_date' => $faker->dateTimeBetween('2020-10-25', '2020-10-27'),
            'factory_warehousing_date' => $faker->dateTimeBetween('2020-10-28', '2020-10-29'),
            'warehouse_receipt_date' => $faker->dateTimeBetween('2020-10-30', '2020-10-31'),
            'item_code' => function() {
            	return Item::all()->random()->item_code;
            } // 22111111150　22111111255　22111111363　3パターン
    ];
});
