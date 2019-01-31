<?php

namespace Tests\Feature;

use App\Campaign\Jobs\{
    UpdateCommanderTag,
    UpdateCommanderArea,
    UpdateCommanderGroup,
    UpdateCommanderUpline,
    UpdateCommanderTagArea,
    UpdateCommanderTagGroup,
    UpdateCommanderTagCampaign,
    UpdateCommanderAreaFromUplineTagArea,
    UpdateCommanderGroupFromUplineTagGroup
};
use App\Missive\Jobs\UpdateContact;
use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderRegistrationUpdated;

class SubscriberRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function setup()
    {
        parent::setUp();

        $this->campaign = $this->conjureCampaign();

        $this->group = $this->conjureGroup();
        $this->area = $this->conjureArea();
        $this->tag = $this->conjureTag();
        $this->tag
            ->setCampaign($this->campaign, true)
            ->setGroup($this->group)
            ->setArea($this->area)
            ;
        $this->tagger = $this->tag->tagger;
    }

    /** @test */
    function commander_can_send_registration_command()
    {
        /*** arrange ***/
        $handle = $this->faker->name;
        $missive = "{$this->tag->code} {$handle}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();
        //the ff: line is needed to make sure that UpdateContact job is pushed
        (new UpdateContact($this->commander, $handle))->handle();

         /*** assert ***/
        $this->assertCommandIssued($missive);
        $this->assertEquals($this->commander->handle, $handle);
        Notification::assertSentTo($this->commander, CommanderRegistrationUpdated::class);
        Queue::assertPushed(UpdateContact::class);
        Queue::assertPushed(UpdateCommanderUpline::class);
        Queue::assertPushed(UpdateCommanderAreaFromUplineTagArea::class);
        Queue::assertPushed(UpdateCommanderGroupFromUplineTagGroup::class);
        Queue::assertPushed(UpdateCommanderTag::class);
        Queue::assertPushed(ChargeAirtime::class);
     }

    /** @test */
    function commander_can_send_registration_command_amd_then_some()
    {
        /*** arrange ***/
        $handle = $this->faker->name;
        $missive = "{$this->tag->code} {$handle}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();
        //the ff: 4 lines are needed to make sure that UpdateCommanderTagGroup job is pushed
        (new UpdateContact($this->commander, $handle))->handle();
        (new UpdateCommanderUpline($this->commander, $this->tagger))->handle();
        (new UpdateCommanderTag($this->commander, $code = $this->faker->word))->handle();
        (new UpdateCommanderArea($this->commander, $area = $this->conjureArea()))->handle();
        (new UpdateCommanderGroup($this->commander, $group = $this->conjureGroup()))->handle();

         /*** assert ***/
        $this->assertCommandIssued($missive);
        $this->assertEquals($this->commander->upline->handle, $this->tagger->handle);
        $this->assertEquals($this->commander->tags()->first()->code, $code);
        $this->assertEquals($this->commander->areas()->first()->name, $area->name);
        $this->assertEquals($this->commander->groups()->first()->name, $group->name);
        Queue::assertPushed(UpdateCommanderTagCampaign::class);
        Queue::assertPushed(UpdateCommanderTagArea::class);
        Queue::assertPushed(UpdateCommanderTagGroup::class);
    }
}
