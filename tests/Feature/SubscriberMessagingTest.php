<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use Illuminate\Foundation\Testing\WithFaker;
use App\Campaign\Jobs\UpdateCommanderUpline;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderBroadcastUpdated;
use App\Campaign\Notifications\DownlineAnnouncementUpdated;
use App\Campaign\Notifications\DescendantsBroadcastUpdated;
use App\Campaign\Notifications\CommanderAnnouncementUpdated;

class SubscriberMessagingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $downline1;

    protected $downline2;

    protected $downline3;

    protected $downline4;

    protected $downline5;

    protected $downline6;

    function setup()
    {
        parent::setUp();

        $this->downline1 = $this->conjureContact();
        $this->downline2 = $this->conjureContact();
        $this->downline3 = $this->conjureContact();
        $this->downline4 = $this->conjureContact();
        $this->downline5 = $this->conjureContact();
        $this->downline6 = $this->conjureContact();

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
        Queue::assertPushed(ChargeAirtime::class);
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
        Queue::assertPushed(ChargeAirtime::class);
    }
}
