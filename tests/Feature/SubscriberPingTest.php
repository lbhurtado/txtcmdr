<?php

namespace Tests\Feature;

use Tests\TextCommanderCase as TestCase;
use App\Charging\Jobs\ChargeAirtime;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Campaign\Notifications\CommanderTestUpdated;
use Illuminate\Support\Facades\{Queue, Notification};

class SubscriberPingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function setup()
    {
        parent::setUp();
        $this->artisan('db:seed',['--class' => 'AirtimeSeeder']);
    }

    /** @test */
    function commander_can_send_test_command()
    {
        $command = $message = 'ping';
        $from = $this->commander->mobile;
        $to = $this->destination;

        Queue::fake();
        Notification::fake();
        Notification::assertNothingSent();

        $this->json('POST', $this->endpoint, $this->getJsonData($command, $from, $to))
            ->assertStatus(200)
            ->assertJson(['data' => compact('from', 'to', 'message')])
            ;

        Notification::assertSentTo($this->commander, CommanderTestUpdated::class);
        Queue::assertPushed(ChargeAirtime::class); 
    }
}