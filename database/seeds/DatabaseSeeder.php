<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUserSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(ClientCompaniesTableSeeder::class);
        $this->call(TransportCompaniesTableSeeder::class);
        $this->call(OrderItemsTableSeeder::class);
        $this->call(InventoriesTableSeeder::class);
    }
}
