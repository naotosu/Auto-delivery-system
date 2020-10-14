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
        	'id' => '1',
            'item_code' => "BB111111150",
            'end_user_id' => '1',
            'client_user_id' => '3',
            'delivery_user_id' => '6',
            'transport_id' => '1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        	],
            [
            'id' => '2',
            'item_code' => "BB111111255",
            'end_user_id' => '1',
            'client_user_id' => '3',
            'delivery_user_id' => '7',
            'transport_id' => '1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'id' => '3',
            'item_code' => "BB111111363",
            'end_user_id' => '2',
            'client_user_id' => '5',
            'delivery_user_id' => '5',
            'transport_id' => '2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]]);
    }
}
