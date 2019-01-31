<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Jobs\UpdateCommanderTag;
use App\Campaign\Jobs\UpdateCommanderArea;
use App\Campaign\Jobs\UpdateCommanderGroup;
use App\Campaign\Domain\Classes\CommandKey;
use Illuminate\Foundation\Testing\WithFaker;
use App\Campaign\Jobs\UpdateCommanderTagArea;
use App\Campaign\Jobs\UpdateCommanderTagGroup;
use App\Campaign\Jobs\UpdateCommanderTagCampaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Campaign\Notifications\CommanderTagUpdated;
use Illuminate\Support\Facades\{Queue, Notification};

class SubscriberTagTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    function commander_can_send_tag_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::TAG);
        $code = $this->faker->word;
        $campaign = $this->conjureCampaign();
        $missive = "{$campaign->name}{$command}{$code}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderTagUpdated::class);
        Queue::assertPushed(UpdateCommanderTag::class);
        Queue::assertPushed(UpdateCommanderTagCampaign::class);
        Queue::assertPushed(ChargeAirtime::class);
    }

    /** @test */
    function commander_can_send_tag_command_updating_tag_group_and_area()
    {
        /*** arrange ***/
        $group = $this->conjureGroup();
        $area = $this->conjureArea();
        $missive = "{$this->conjureCampaign()->name}{$this->getCommand(CommandKey::TAG)}{$this->faker->word}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();
        //the ff: 2 lines are needed to make sure that UpdateCommanderTagGroup job is pushed
        (new UpdateCommanderGroup($this->commander, $group))->handle();
        (new UpdateCommanderArea($this->commander, $area))->handle();
        (new UpdateCommanderTag($this->commander, $this->faker->word))->handle();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateCommanderTagGroup::class);
        Queue::assertPushed(UpdateCommanderTagArea::class);
    }
}
