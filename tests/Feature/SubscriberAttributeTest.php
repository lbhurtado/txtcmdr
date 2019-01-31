<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Jobs\UpdateCommanderAttribute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderAttributeUpdated;

class SubscriberAttributeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function commander_can_attribute_area_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::ATTRIBUTE);
        $missive = "eyes{$command}green";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderAttributeUpdated::class);
        Queue::assertPushed(UpdateCommanderAttribute::class);
        Queue::assertPushed(ChargeAirtime::class);
    }
}
