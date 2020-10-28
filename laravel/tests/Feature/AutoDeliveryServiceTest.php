<?php

namespace Tests\Feature;

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
        $ship_date = date('w', strtotime($now));
        new NoOrderSendMail($ship_date);
        Mail::assertQueued(MailBuilder::class, 1);
    }
}
