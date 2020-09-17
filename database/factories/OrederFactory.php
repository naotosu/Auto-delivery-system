<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Order::class, function (Faker $faker) {
    return [
        'item_id' => $faker->$min = 22111111111,$max =　22111111113, 
        'delivery_date' => $faker->date,
        'quantity' => $faker->$min = 2000,$max =　20000,
        'update_user_id' => $faker->$min = 1,$max =　15,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
