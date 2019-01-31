<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Jobs\UpdateCommanderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderStatusUpdated;
use App\Campaign\Notifications\CommanderStatusUplineUpdated;

class SubscriberStatusTest extends TestCase
{
    use RefreshDatabase;

    function setup()
    {
        parent::setUp();

        //the ff: line is needed to make sure that CommanderGroupUplineUpdated notification is sent
        $this->tagger = $this->persistUpline();
    }

    /** @test */
    function commander_can_attribute_attribute_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::STATUS);
        $missive = "50{$command}status/reason";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderStatusUpdated::class);
        Notification::assertSentTo($this->tagger, CommanderStatusUplineUpdated::class);
        Queue::assertPushed(UpdateCommanderStatus::class);
        Queue::assertPushed(ChargeAirtime::class);
    }
}
