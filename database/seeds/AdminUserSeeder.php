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
		  'name' => 'ns',
		  'email' => '1111@gmail.com',
		  'password' => Hash::make('root'),
 		]);
    }
}
