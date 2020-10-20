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
    		'item_code' => 'BB111111150',
	        'name' => 'S45C炭素鋼',
	        'size' => '50',
	        'shape' => 'φ',
	        'spec' => 'R',
	        'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
	        ],
            [
            'id' => '2',
            'item_code' => 'BB111111255',
	        'name' => 'SCR肌焼鋼',
	        'size' => '55',
	        'shape' => 'φ',
	        'spec' => 'R',
	        'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
	        ],
            [
            'id' => '3',
            'item_code' => 'BB111111363',
	        'name' => 'SCM強靭鋼',
	        'size' => '63',
	        'shape' => 'φ',
	        'spec' => 'EN',
	        'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
	        ]]);
    }
}
