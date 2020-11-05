<?php

use Illuminate\Database\Seeder;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_items')->insert([[
            'order_id' => '3',
            'item_code' => 'BB111111363',
            'ship_date' => '2020-11-1',
            'weight' => '4000',
            ],
            [
            'order_id' => '3',
            'item_code' => 'BB111111363',
            'ship_date' => '2020-11-5',
            'weight' => '120000',
            ]]);

        factory('App\Models\OrderItem', 40)->create();
    }
}
