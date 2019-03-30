<?php

namespace Tests\Feature;

use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Jobs\UpdateCommanderAttribute;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderAttributeUpdated;

class SubscriberAttributeTest extends TestCase
{
    /** @test */
    function commander_can_send_attribute_command()
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
        $this->assertAirtimeCharged();
    }
}
