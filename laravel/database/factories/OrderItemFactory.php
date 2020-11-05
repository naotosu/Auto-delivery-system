<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Item;

$factory->define(App\Models\OrderItem::class, function (Faker $faker) {
    return [
    	'order_id' => $faker->numberBetween($min = 1, $max = 3),
    	'ship_date' => $faker->dateTimeBetween('2020-11-17', '2020-12-27'),
		'weight' => $faker->numberBetween($min = 2000, $max = 20000),
        'item_code' => function() {
    	return Item::all()->random()->item_code;
    	},
    ];
});
