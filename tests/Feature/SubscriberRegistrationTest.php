<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Missive\Jobs\UpdateContact;
use App\Campaign\Jobs\UpdateCommanderUpline;
use App\Campaign\Jobs\UpdateCommanderAreaFromUplineTagArea;
use App\Campaign\Jobs\UpdateCommanderGroupFromUplineTagGroup;
use App\Campaign\Jobs\UpdateCommanderTag;
use App\Campaign\Jobs\UpdateCommanderTagCampaign;
use App\Campaign\Notifications\CommanderRegistrationUpdated;
use App\Campaign\Domain\Classes\CommandKey;

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
        //the ff: 2 lines are needed to make sure that UpdateCommanderTagGroup job is pushed
        (new UpdateContact($this->commander, $handle))->handle();
        // (new UpdateCommanderUpline($this->commander, $this->tagger))->handle();
        // (new UpdateCommanderGroup($this->commander, $group))->handle();
        // (new UpdateCommanderTag($this->commander, $this->faker->word))->handle();

        // /*** assert ***/
        $this->assertCommandIssued($missive);
        $this->assertEquals($this->commander->handle, $handle);

        dd($this->campaign);
        // $this->assertEquals($this->commander->upline->handle, $this->tagger->handle);

        Queue::assertPushed(UpdateContact::class);
        Queue::assertPushed(UpdateCommanderUpline::class);
        Queue::assertPushed(UpdateCommanderAreaFromUplineTagArea::class);
        Queue::assertPushed(UpdateCommanderGroupFromUplineTagGroup::class);
        Queue::assertPushed(UpdateCommanderTag::class);
        Queue::assertPushed(UpdateCommanderTagCampaign::class);
        
        Queue::assertPushed(ChargeAirtime::class);
     }
}
