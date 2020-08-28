<?php

use Illuminate\Database\Seeder;
use App\User;

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
		  'name' => 'ns',
		  'email' => 're13brb26l28@hotmail.com',
		  'password' => Hash::make('882'),
 		]);
    }
}
