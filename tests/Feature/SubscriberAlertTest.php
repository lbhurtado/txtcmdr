<?php

namespace Tests\Feature;

use App\Campaign\Notifications\CommanderAlertUpdated;
use App\Campaign\Notifications\CommanderAlertUplineUpdated;
use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Jobs\UpdateCommanderTag;
use App\Campaign\Jobs\UpdateCommanderArea;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Jobs\UpdateCommanderTagArea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Campaign\Notifications\CommanderAreaUpdated;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderAreaUplineUpdated;

class SubscriberAlertTest extends TestCase
{
    use RefreshDatabase;

    protected $tagger;

    function setup()
    {
        parent::setUp();

        //the ff: line is needed to make sure that CommanderAreaUplineUpdated notification is sent
        $this->tagger = $this->persistUpline();
    }

    /** @test */
    function commander_can_send_alert_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::ALERT);
        $alert = $this->conjureAlert();
        $missive = "{$command}{$alert->name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();
        //the ff: 2 lines are needed to make sure that UpdateCommanderTagGroup job is pushed
//        (new UpdateCommanderArea($this->commander, $area))->handle();
//        (new UpdateCommanderTag($this->commander, $this->faker->word))->handle();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderAlertUpdated::class);
        Notification::assertSentTo($this->tagger, CommanderAlertUplineUpdated::class);
        Queue::assertPushed(ChargeAirtime::class);
    }
}
