<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('items')->insert([[
    		'id' => '1',
	        'item_id' => '22111111150',
	        'name' => 'S45C炭素鋼',
	        'size' => '50',
	        'shape' => 'φ',
	        'spec' => 'R',
	        'end_user_id' => '1',
	        'client_user_id' => '3',
	        'delivery_user_id' => '6',
	        'transport_id' => '1',
	        'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
	        ],
            [
            'id' => '2',
            'item_id' => '22111111255',
	        'name' => 'SCR肌焼鋼',
	        'size' => '55',
	        'shape' => 'φ',
	        'spec' => 'R',
	        'end_user_id' => '1',
	        'client_user_id' => '3',
	        'delivery_user_id' => '7',
	        'transport_id' => '1',
	        'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
	        ],
            [
            'id' => '3',
            'item_id' => '22111111363',
	        'name' => 'SCM強靭鋼',
	        'size' => '63',
	        'shape' => 'φ',
	        'spec' => 'EN',
	        'end_user_id' => '2',
	        'client_user_id' => '5',
	        'delivery_user_id' => '5',
	        'transport_id' => '1',
	        'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
	        ]]);
    }
}
