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
use App\Campaign\Domain\Models\Tag;
use App\Missive\Jobs\UpdateContact;
use Tests\TextCommanderCase as TestCase;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderRegistrationUpdated;

class SubscriberRegistrationTest extends TestCase
{
    protected $code;

    function setup(): void
    {
        parent::setUp();

        $this->tag = $this->pickRandomTag() ?? $this->conjureTag();
        $this->code = $this->tag->code ?? $this->faker->word;
        $this->campaign = $this->pickRandomCampaign() ?? $this->conjureCampaign();
        $this->group = $this->pickRandomGroup() ?? $this->conjureGroup();
        $this->area = $this->pickRandomArea() ?? $this->conjureArea();
//        (new UpdateCommanderTag($this->commander, $this->code))->handle();
    }

    /** @test */
    function commander_register_tag_command()
    {
        /*** arrange ***/
        $code = "{$this->code}";

//        tap(factory(Tag::class)->create(compact('code')), function ($tag) {
//            $tag->setCampaign($this->campaign, true);
//        });

        $handle = $this->faker->name;
        $missive = "{$code} {$handle}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();
        //the ff: line is needed to make sure that UpdateContact job is pushed

         /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateContact::class, function ($job) {
            return $job->contact->handle == $this->commander->handle;
        });

        Queue::assertPushed(UpdateCommanderUpline::class);
        if (optional($this->tag->area, function ($area) {
            Queue::assertPushed(UpdateCommanderAreaFromUplineTagArea::class, function ($job) use ($area) {
                return $job->commander->is($this->commander) && $job->area->is($area);
            });

            return true;
        }) != true) Queue::assertNotPushed(UpdateCommanderAreaFromUplineTagArea::class);

        if (optional($this->tag->group, function ($group) {
                Queue::assertPushed(UpdateCommanderGroupFromUplineTagGroup::class, function ($job) use ($group) {
                    return $job->commander->is($this->commander) && $job->group->is($group);
                });

                return true;
            }) != true) Queue::assertNotPushed(UpdateCommanderAreaFromUplineTagArea::class);

        Queue::assertNotPushed(UpdateCommanderTag::class);
        Notification::assertSentTo($this->commander, CommanderRegistrationUpdated::class);
        $this->assertAirtimeCharged();
     }

//    /** @test */
    function commander_register_tag_area_command()
    {
        /*** arrange ***/
        $code = "{$this->code} {$this->area->name}";

        tap(factory(Tag::class)->create(compact('code')), function ($tag) {
            $tag
                ->setCampaign($this->campaign, true)
                ->setArea($this->area)
            ;
        });

        $handle = $this->faker->name;
        $missive = "{$code} {$handle}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();
        //the ff: line is needed to make sure that UpdateContact job is pushed
        (new UpdateContact($this->commander, $handle))->handle();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        $this->assertEquals($this->commander->handle, $handle);
        Queue::assertPushed(UpdateContact::class);
        Queue::assertPushed(UpdateCommanderUpline::class);
        Queue::assertPushed(UpdateCommanderAreaFromUplineTagArea::class);
        Queue::assertNotPushed(UpdateCommanderGroupFromUplineTagGroup::class);
        Queue::assertNotPushed(UpdateCommanderTag::class);
        Notification::assertSentTo($this->commander, CommanderRegistrationUpdated::class);
        $this->assertAirtimeCharged();
    }

//    /** @test */
    function commander_can_send_registration_command_amd_then_some()
    {
        /*** arrange ***/
        $code = "{$this->code}";

        $this->tagger = tap(factory(Tag::class)->create(compact('code')), function ($tag) {
            $tag->setCampaign($this->campaign, true);
        })->tagger;


        $handle = $this->faker->name;
        $missive = "{$code} {$handle}";

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
        $this->assertTrue($this->commander->parent->is($this->tagger));

        $this->assertEquals($this->commander->tag()->first()->code, $code);
        $this->assertTrue($this->commander->areas()->first()->is($area));
        $this->assertTrue($this->commander->groups()->first()->is($group));
        Queue::assertNotPushed(UpdateCommanderTagCampaign::class);
        Queue::assertNotPushed(UpdateCommanderTagArea::class);
        Queue::assertNotPushed(UpdateCommanderTagGroup::class);
        $this->assertAirtimeCharged();
    }
}
