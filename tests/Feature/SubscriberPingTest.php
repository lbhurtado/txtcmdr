<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use App\Charging\Domain\Classes\AirtimeKey;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Notifications\CommanderTestUpdated;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Jobs\Charge\ChargeCommanderOutgoingSMS;

class SubscriberPingTest extends TestCase
{
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
        Queue::assertPushed(ChargeAirtime::class, function ($job) {
            return
                ($job->commander->is($this->commander)) &&
                ($job->availment == AirtimeKey::INCOMING_SMS)
                ;
        });
        Queue::assertPushed(ChargeCommanderOutgoingSMS::class, function ($job) {
            return
                $job->commander->is($this->commander)
                ;
        });
    }
}
