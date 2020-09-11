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
        $this->call(ClientCompaniesTableSeeder::class);
        $this->call(TransportCompaniesTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        factory('App\Inventorie', 200)->create();
    }
}
