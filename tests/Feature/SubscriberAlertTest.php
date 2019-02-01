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
use App\Campaign\Notifications\CommanderAlertToGroup;
use App\Campaign\Notifications\CommanderAreaUplineUpdated;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Models\Group;

class SubscriberAlertTest extends TestCase
{
    use RefreshDatabase;

    protected $tagger;

    function setup()
    {
        parent::setUp();

        $this->contact1 = $this->conjureContact();
        $this->contact2 = $this->conjureContact();
        $this->contact3 = $this->conjureContact();
        $this->contact4 = $this->conjureContact();
        $this->group = $this->conjureGroup();
        $this->alert = $this->conjureAlert();
        $this->group->assignAlert($this->alert);
        $this->contact1->assignGroup($this->group);
        $this->contact2->assignGroup($this->group);

        //the ff: line is needed to make sure that CommanderAreaUplineUpdated notification is sent
        $this->tagger = $this->persistUpline();
    }

    /** @test */
    function commander_can_send_alert_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::ALERT);
        $missive = "{$command}{$this->alert->name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderAlertUpdated::class);
        Notification::assertSentTo($this->tagger, CommanderAlertUplineUpdated::class);
        Notification::assertSentTo($this->contact1, CommanderAlertToGroup::class);
        Notification::assertSentTo($this->contact2, CommanderAlertToGroup::class);
        Notification::assertNotSentTo($this->contact3, CommanderAlertToGroup::class);
        Notification::assertNotSentTo($this->contact4, CommanderAlertToGroup::class);
        Queue::assertPushed(ChargeAirtime::class);
    }
}
