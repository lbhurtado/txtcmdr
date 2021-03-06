<?php

namespace Tests\Feature;

use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Jobs\UpdateCommanderCheckin;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderCheckinUpdated;
use App\Campaign\Notifications\CommanderCheckinUplineUpdated;

class SubscriberCheckinTest extends TestCase
{
    protected $tagger;

    function setup(): void
    {
        parent::setUp();

        //the ff: line is needed to make sure that CommanderAreaUplineUpdated notification is sent
        $this->tagger = $this->persistUpline();
    }

    /** @test */
    function commander_can_send_checkin_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::CHECKIN);
        $missive = "{$command}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderCheckinUpdated::class);
        Notification::assertSentTo($this->tagger, CommanderCheckinUplineUpdated::class);

        Queue::assertPushed(UpdateCommanderCheckin::class);
        $this->assertAirtimeCharged();
    }
}
