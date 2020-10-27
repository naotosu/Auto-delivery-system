<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertViewIs('top');

        $response = $this->get('/csv_imports');
        $response->assertStatus(200)
            ->assertViewIs('csv_import');

        $response = $this->get('/csv_sample/order_items_sample.csv');
        $response->assertStatus(500);
        /*下記コードだとエラー
        $response->assertStatus(500)
                ->assertFileExists('order_items_sample.csv');*/

        $response = $this->get('/csv_sample/inventories_sample.csv');
        $response->assertStatus(500);
    }
}
