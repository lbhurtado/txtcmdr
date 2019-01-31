<?php

namespace Tests\Feature;

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

class SubscriberAreaTest extends TestCase
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
    function commander_can_send_area_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::AREA);
        $area = $this->conjureArea();
        $missive = "{$command}{$area->name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();
        //the ff: 2 lines are needed to make sure that UpdateCommanderTagGroup job is pushed
        (new UpdateCommanderArea($this->commander, $area))->handle();
        (new UpdateCommanderTag($this->commander, $this->faker->word))->handle();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderAreaUpdated::class);
        Notification::assertSentTo($this->tagger, CommanderAreaUplineUpdated::class);
        Queue::assertPushed(UpdateCommanderArea::class);
        Queue::assertPushed(UpdateCommanderTagArea::class);
        Queue::assertPushed(ChargeAirtime::class);
    }
}
