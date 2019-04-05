<?php

namespace Tests\Feature;

use Tests\TextCommanderCase as TestCase;
use App\Campaign\Jobs\UpdateCommanderTag;
use App\Campaign\Jobs\UpdateCommanderArea;
use App\Campaign\Jobs\UpdateCommanderGroup;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Jobs\UpdateCommanderTagArea;
use App\Campaign\Jobs\UpdateCommanderTagGroup;
use App\Campaign\Jobs\UpdateCommanderTagCampaign;
use App\App\Stages\UpdateCommanderUnTagAreaStage;
use App\App\Stages\UpdateCommanderUnTagGroupStage;
use App\Campaign\Notifications\CommanderTagUpdated;
use Illuminate\Support\Facades\{Queue, Notification};

class SubscriberTagTest extends TestCase
{
    protected $command;

    protected $campaign;

    function setup(): void
    {
        parent::setUp();

        $this->command = $this->getCommand(CommandKey::TAG);
        $this->campaign = $this->pickRandomCampaign() ?? $this->conjureCampaign();
    }

    /** @test */
    function commander_can_send_tag_area_command()
    {
        /*** arrange ***/
        $area = $this->pickRandomArea() ?? $this->conjureArea();
        $missive = "{$this->command} @{$area->name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateCommanderTag::class);
        Queue::assertPushed(UpdateCommanderArea::class);
        Queue::assertPushed(UpdateCommanderTagArea::class);
        Queue::assertNotPushed(UpdateCommanderTagCampaign::class);
        Queue::assertNotPushed(UpdateCommanderUnTagGroupStage::class);
        Notification::assertSentTo($this->commander, CommanderTagUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    function commander_can_send_tag_area_campaign_command()
    {
        /*** arrange ***/
        $area = $this->pickRandomArea() ?? $this->conjureArea();
        $missive = "{$this->command} @{$area->name} {$this->campaign->name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateCommanderTag::class);
        Queue::assertPushed(UpdateCommanderArea::class);
        Queue::assertPushed(UpdateCommanderTagArea::class);
        Queue::assertPushed(UpdateCommanderTagCampaign::class);
        Queue::assertNotPushed(UpdateCommanderUnTagGroupStage::class);
        Notification::assertSentTo($this->commander, CommanderTagUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    function commander_can_send_tag_group_command()
    {
        /*** arrange ***/
        $group = $this->pickRandomGroup() ?? $this->conjureGroup();
        $missive = "{$this->command} &{$group->name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateCommanderTag::class);
        Queue::assertPushed(UpdateCommanderGroup::class);
        Queue::assertPushed(UpdateCommanderTagGroup::class);
        Queue::assertNotPushed(UpdateCommanderTagCampaign::class);
        Queue::assertNotPushed(UpdateCommanderUnTagAreaStage::class);
        Notification::assertSentTo($this->commander, CommanderTagUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    function commander_can_send_tag_group_campaign_command()
    {
        /*** arrange ***/
        $group = $this->pickRandomGroup() ?? $this->conjureGroup();
        $missive = "{$this->command} &{$group->name} {$this->campaign->name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateCommanderTag::class);
        Queue::assertPushed(UpdateCommanderGroup::class);
        Queue::assertPushed(UpdateCommanderTagGroup::class);
        Queue::assertPushed(UpdateCommanderTagCampaign::class);
        Queue::assertNotPushed(UpdateCommanderUnTagAreaStage::class);
        Notification::assertSentTo($this->commander, CommanderTagUpdated::class);
        $this->assertAirtimeCharged();
    }
}
