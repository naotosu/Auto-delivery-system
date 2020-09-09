<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('orders')->insert([[
        	'item_id' => '22111111150',
        	'delivery_date' => date('2020-9-15'),
        	'quantity' => '20000',
            'delivery_user_id' => '6',
        	'update_user_id' => '1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        	],
            [
            'item_id' => '22111111150',
        	'delivery_date' => date('2020-09-17'),
        	'quantity' => '20000',
            'delivery_user_id' => '6',
        	'update_user_id' => '1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        	],
            [
        	'item_id' => '22111111150',
        	'delivery_date' => date('2020-09-23'),
        	'quantity' => '20000',
            'delivery_user_id' => '6',
        	'update_user_id' => '1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'item_id' => '22111111255',
            'delivery_date' => date('2020-09-16'),
            'quantity' => '20000',
            'delivery_user_id' => '7',
            'update_user_id' => '1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'item_id' => '22111111255',
            'delivery_date' => date('2020-09-18'),
            'quantity' => '20000',
            'delivery_user_id' => '7',
            'update_user_id' => '1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'item_id' => '22111111363',
            'delivery_date' => date('2020-09-18'),
            'quantity' => '2000',
            'delivery_user_id' => '5',
            'update_user_id' => '1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'item_id' => '22111111363',
            'delivery_date' => date('2020-09-25'),
            'quantity' => '2000',
            'delivery_user_id' => '7',
            'update_user_id' => '1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]]);
    }
}
