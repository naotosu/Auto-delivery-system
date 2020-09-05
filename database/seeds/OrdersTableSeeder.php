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
        	'item_id' => '22111111111',
        	'delivery_date' => date('2020-9-15'),
        	'quantity' => '20000',
        	'update_user_id' => '2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        	],
            [
            'item_id' => '22111111111',
        	'delivery_date' => date('2020-09-17'),
        	'quantity' => '20000',
        	'update_user_id' => '2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        	],
            [
        	'item_id' => '22111111111',
        	'delivery_date' => date('2020-09-23'),
        	'quantity' => '20000',
        	'update_user_id' => '2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'item_id' => '22111111112',
            'delivery_date' => date('2020-09-16'),
            'quantity' => '20000',
            'update_user_id' => '2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'item_id' => '22111111112',
            'delivery_date' => date('2020-09-18'),
            'quantity' => '20000',
            'update_user_id' => '2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'item_id' => '22111111113',
            'delivery_date' => date('2020-09-18'),
            'quantity' => '20000',
            'update_user_id' => '2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]]);
    }
}
