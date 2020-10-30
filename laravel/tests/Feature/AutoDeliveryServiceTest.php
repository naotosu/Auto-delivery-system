<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\AutoDeliveryService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AutoDeliveryServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoOrderSendMail()
    {
        Mail::fake();
        $now = Carbon::now();
        $ship_date = date('y/m/d', strtotime($now));
        AutoDeliveryService::NoOrderSendMail($ship_date);
        Mail::assertSent(Approved::class, 1);
    }
}
