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
    public function testTopPage()
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertViewIs('top');

    }

    public function testCsvImportsPage()
    {
        $response = $this->get('/csv_imports');
        $response->assertStatus(200)
            ->assertViewIs('csv_import');
    }

}
