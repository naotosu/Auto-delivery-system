<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create([
		  'name' => 'gest',
		  'email' => 'auto.delivery.system2020gest@gmail.com',
		  'password' => Hash::make('auto111222'),
 		]);
    }
}
