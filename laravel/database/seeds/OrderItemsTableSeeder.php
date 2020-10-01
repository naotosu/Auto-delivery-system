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
            'ship_date' => '2020-10-15',
            'quantity' => '4000',
            'temporary_flag' => '1',
            'update_user_id' => '1',
            ]]);

        factory('App\Models\OrderItem', 20)->create();
    }
}
