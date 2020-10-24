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
		  'name' => 'guest',
		  'email' => 'auto.delivery.system2020@gmail.com',
		  'password' => Hash::make('password'),
 		]);
    }
}
