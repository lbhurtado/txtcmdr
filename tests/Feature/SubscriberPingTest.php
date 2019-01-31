<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Campaign\Notifications\CommanderTestUpdated;
use Illuminate\Support\Facades\{Queue, Notification};

class SubscriberPingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function commander_can_send_test_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::TEST);
        $missive = "{$command}";

        /*** act ***/
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderTestUpdated::class);
        Queue::assertPushed(ChargeAirtime::class); 
    }
}
