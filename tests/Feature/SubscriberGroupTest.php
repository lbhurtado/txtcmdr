<?php

namespace Tests\Feature;

use Tests\TextCommanderCase as TestCase;
use App\Campaign\Jobs\UpdateCommanderTag;
use App\Campaign\Jobs\UpdateCommanderGroup;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Jobs\UpdateCommanderTagGroup;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderGroupUpdated;
use App\Campaign\Notifications\CommanderGroupUplineUpdated;

class SubscriberGroupTest extends TestCase
{
    protected $tagger;

    function setup()
    {
        parent::setUp();

        //the ff: line is needed to make sure that CommanderGroupUplineUpdated notification is sent
        $this->tagger = $this->persistUpline();
    }

    /** @test */
    function commander_can_send_group_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::GROUP);
        $group = $this->pickRandomGroup() ?? $this->conjureGroup();
        $input = ucfirst(strtolower($group->name)); //add some difficulty
        $missive = "{$command}{$input}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();
        //the ff: 2 lines are needed to make sure that UpdateCommanderTagGroup job is pushed
        (new UpdateCommanderGroup($this->commander, $group))->handle();
        (new UpdateCommanderTag($this->commander, $this->faker->word))->handle();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderGroupUpdated::class);
        Notification::assertSentTo($this->tagger, CommanderGroupUplineUpdated::class);
        Queue::assertPushed(UpdateCommanderGroup::class);
        Queue::assertNotPushed(UpdateCommanderTagGroup::class);
        $this->assertAirtimeCharged();
    }
}
