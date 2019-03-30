<?php

namespace Tests\Feature;

use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Jobs\UpdateCommanderUpline;
use App\Campaign\Notifications\CommanderSendToArea;
use App\Campaign\Notifications\CommanderSendToGroup;
use App\Campaign\Notifications\CommanderSendUpdated;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderReportUpdated;
use App\Campaign\Notifications\CommanderBroadcastUpdated;
use App\Campaign\Notifications\DownlineAnnouncementUpdated;
use App\Campaign\Notifications\DescendantsBroadcastUpdated;
use App\Campaign\Notifications\CommanderAnnouncementUpdated;
use App\Campaign\Notifications\CommanderReportUplineUpdated;

class SubscriberMessagingTest extends TestCase
{
    protected $downline1;

    protected $downline2;

    protected $downline3;

    protected $downline4;

    protected $downline5;

    protected $downline6;

    function setup()
    {
        parent::setUp();

        $this->area1 = $this->conjureArea();
        $this->area2 = $this->conjureArea();

        $this->group1 = $this->conjureGroup();
        $this->group2 = $this->conjureGroup();

        $this->downline1 = $this->conjureContact();
        $this->downline2 = $this->conjureContact();
        $this->downline3 = $this->conjureContact();
        $this->downline4 = $this->conjureContact();
        $this->downline5 = $this->conjureContact();
        $this->downline6 = $this->conjureContact();

        $this->downline1->syncAreas($this->area1);
        $this->downline2->syncAreas($this->area1);
        $this->downline3->syncAreas($this->area1);
        $this->downline4->syncAreas($this->area2);
        $this->downline5->syncAreas($this->area2);
        $this->downline6->syncAreas($this->area2);

        $this->downline1->syncGroups($this->group1);
        $this->downline2->syncGroups($this->group1);
        $this->downline3->syncGroups($this->group1);
        $this->downline4->syncGroups($this->group2);
        $this->downline5->syncGroups($this->group2);
        $this->downline6->syncGroups($this->group2);

        $this->tagger = $this->persistUpline();

        (new UpdateCommanderUpline($this->downline1, $this->commander))->handle();
        (new UpdateCommanderUpline($this->downline2, $this->commander))->handle();
        (new UpdateCommanderUpline($this->downline3, $this->downline1))->handle();
        (new UpdateCommanderUpline($this->downline4, $this->downline2))->handle();
        (new UpdateCommanderUpline($this->downline5, $this->downline3))->handle();
        (new UpdateCommanderUpline($this->downline6, $this->downline4))->handle();
    }

    /** @test */
    function commander_can_send_announcement_to_downline()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::ANNOUNCE);
        $message = $this->faker->sentence;
        $missive = "{$command}{$message}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderAnnouncementUpdated::class);
        Notification::assertSentTo($this->downline1, DownlineAnnouncementUpdated::class);
        Notification::assertSentTo($this->downline2, DownlineAnnouncementUpdated::class);
        Notification::assertNotSentTo($this->downline3, DownlineAnnouncementUpdated::class);
        Notification::assertNotSentTo($this->downline4, DownlineAnnouncementUpdated::class);
        Notification::assertNotSentTo($this->downline5, DownlineAnnouncementUpdated::class);
        Notification::assertNotSentTo($this->downline6, DownlineAnnouncementUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    function commander_can_send_broadcast_to_descendants()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::BROADCAST);
        $message = $this->faker->sentence;
        $missive = "{$command}{$message}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderBroadcastUpdated::class);
        Notification::assertSentTo($this->downline1, DescendantsBroadcastUpdated::class);
        Notification::assertSentTo($this->downline2, DescendantsBroadcastUpdated::class);
        Notification::assertSentTo($this->downline3, DescendantsBroadcastUpdated::class);
        Notification::assertSentTo($this->downline4, DescendantsBroadcastUpdated::class);
        Notification::assertSentTo($this->downline5, DescendantsBroadcastUpdated::class);
        Notification::assertSentTo($this->downline6, DescendantsBroadcastUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    function commander_can_send_messages_to_an_area()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::SEND);
        $message = $this->faker->sentence;
        $missive = "@{$this->area1->name}{$command}{$message}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderSendUpdated::class);
        Notification::assertSentTo($this->downline1, CommanderSendToArea::class);
        Notification::assertSentTo($this->downline2, CommanderSendToArea::class);
        Notification::assertSentTo($this->downline3, CommanderSendToArea::class);
        Notification::assertNotSentTo($this->downline4, CommanderSendToArea::class);
        Notification::assertNotSentTo($this->downline5, CommanderSendToArea::class);
        Notification::assertNotSentTo($this->downline6, CommanderSendToArea::class);
        $this->assertAirtimeCharged();

        /*** arrange ***/
        $command = $this->getCommand(CommandKey::SEND);
        $message = $this->faker->sentence;
        $missive = "@{$this->area2->name}{$command}{$message}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderSendUpdated::class);
        Notification::assertNotSentTo($this->downline1, CommanderSendToArea::class);
        Notification::assertNotSentTo($this->downline2, CommanderSendToArea::class);
        Notification::assertNotSentTo($this->downline3, CommanderSendToArea::class);
        Notification::assertSentTo($this->downline4, CommanderSendToArea::class);
        Notification::assertSentTo($this->downline5, CommanderSendToArea::class);
        Notification::assertSentTo($this->downline6, CommanderSendToArea::class);
    }

    /** @test */
    function commander_can_send_messages_to_a_group()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::SEND);
        $message = $this->faker->sentence;
        $missive = "&{$this->group1->name}{$command}{$message}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderSendUpdated::class);
        Notification::assertSentTo($this->downline1, CommanderSendToGroup::class);
        Notification::assertSentTo($this->downline2, CommanderSendToGroup::class);
        Notification::assertSentTo($this->downline3, CommanderSendToGroup::class);
        Notification::assertNotSentTo($this->downline4, CommanderSendToGroup::class);
        Notification::assertNotSentTo($this->downline5, CommanderSendToGroup::class);
        Notification::assertNotSentTo($this->downline6, CommanderSendToGroup::class);
        $this->assertAirtimeCharged();

        /*** arrange ***/
        $command = $this->getCommand(CommandKey::SEND);
        $message = $this->faker->sentence;
        $missive = "&{$this->group2->name}{$command}{$message}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderSendUpdated::class);
        Notification::assertNotSentTo($this->downline1, CommanderSendToGroup::class);
        Notification::assertNotSentTo($this->downline2, CommanderSendToGroup::class);
        Notification::assertNotSentTo($this->downline3, CommanderSendToGroup::class);
        Notification::assertSentTo($this->downline4, CommanderSendToGroup::class);
        Notification::assertSentTo($this->downline5, CommanderSendToGroup::class);
        Notification::assertSentTo($this->downline6, CommanderSendToGroup::class);
    }

    /** @test */
    function commander_can_send_report_to_upline()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::REPORT);
        $message = $this->faker->sentence;
        $missive = "{$command}{$message}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderReportUpdated::class);
        Notification::assertSentTo($this->tagger, CommanderReportUplineUpdated::class);
        $this->assertAirtimeCharged();
    }
}
