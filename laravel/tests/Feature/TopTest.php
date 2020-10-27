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
    public function testExampleTopPage()
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertViewIs('top');

    }

    public function testExampleCsvImportsPage()
    {
        $response = $this->get('/csv_imports');
        $response->assertStatus(200)
            ->assertViewIs('csv_import');
    }

    public function testExampleOrderItemsCsvSampleDownlord()
    {
        $response = $this->get('/csv_sample/order_items_sample.csv');
        $response->assertStatus(500);
    }

    public function testExampleInventoriesCsvSampleDownlord()
    {
        $response = $this->get('/csv_sample/inventories_sample.csv');
        $response->assertStatus(500);
    }
}
