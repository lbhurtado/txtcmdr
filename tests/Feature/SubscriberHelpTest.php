<?php

namespace Tests\Feature;

use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Notifications\CommanderHelpUpdated;
use Illuminate\Support\Facades\{Queue, Notification};

class SubscriberHelpTest extends TestCase
{
    /** @test */
    function commander_can_send_test_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::HELP);
        $missive = "{$command}";

        /*** act ***/
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderHelpUpdated::class);
        $this->assertAirtimeCharged();
    }
}
