<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransportCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('transport_companies')->insert([[
        	'id' => '1',
            'name' => 'M運送　知多センター',
            'stuff_name' => 'S',
            'email' => 'aaa0111@gmail.com',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'id' => '2',
            'name' => 'M運送　静岡センター',
            'stuff_name' => 'K',
            'email' => 'aaa0222@gmail.com',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'id' => '3',
            'name' => 'K運送　扇町倉庫',
            'stuff_name' => 'A',
            'email' => 'aaa0333@gmail.com',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]]);       
    }
}
