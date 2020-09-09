<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ClientCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('client_companies')->insert([[
        	'id' => '1',
            'name' => 'H自動車',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'id' => '2',
            'name' => 'HD2輪',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'id' => '3',
            'name' => 'A加工テック',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
			'id' => '4',
            'name' => 'Y鍛造テクノ',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'id' => '5',
            'name' => 'S鉄工',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'id' => '6',
            'name' => 'S鍛造',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ],
            [
            'id' => '7',
            'name' => 'A鍛造',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]]);
    }
}
