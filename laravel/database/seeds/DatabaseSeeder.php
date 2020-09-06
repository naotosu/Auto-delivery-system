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
        $this->call(OrdersTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(ClientCompanyTableSeeder::class);
        $this->call(TransportCompanyTable::class);
    }
}
