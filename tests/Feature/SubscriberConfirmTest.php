<?php

namespace Tests\Feature;

use App\Missive\Jobs\UpdateContact;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Queue, Notification, Event};
use App\Campaign\Jobs\{UpdateCommanderArea, UpdateCommanderGroup};
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Campaign\Notifications\CommanderConfirmUpdated;
use App\Campaign\Domain\Models\Lead;
use App\Campaign\Domain\Models\Stub;
use App\Campaign\Jobs\UpdateCommanderStub;
use App\Campaign\Domain\Events\CommandExecuted;

class SubscriberConfirmTest extends TestCase
{
    use DatabaseTransactions;

    protected $id;

    protected $handle;

    protected $default_excel_file = null;

    public function setUp(): void
    {
        parent::setUp();

        $lead = Lead::all()->random()->first();

        $this->id = '10801';
        $this->handle = 'John Doe';

        $this->id = $lead->code;
        $this->handle = "Rowena";

    }

    /** @test */
    public function commander_confirm_stages()
    {
        /*** arrange ***/
//        $command = $this->getCommand(CommandKey::CONFIRM);
        $missive = "RUTH 10802 John Doe";

        /*** act ***/
        $this->redefineRoutes();
//        Event::fake();
        Queue::fake();
        Notification::fake();

         /*** assert ***/
        $this->assertCommandIssued($missive);

//        Event::assertDispatched(CommandExecuted::class);
        Queue::assertPushed(UpdateContact::class);
        Queue::assertPushed(UpdateCommanderArea::class);
        Queue::assertPushed(UpdateCommanderGroup::class);
        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();
     }

     /** @test */
    public function commander_confirm_using_stubs()
    {
        /*** arrange ***/
        $stub = Stub::all()->random()->first()->code;

//        $command = $this->getCommand(CommandKey::CONFIRM);
        $missive = "HERNANDEZ {$stub} John Doe";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);

        Queue::assertPushed(UpdateContact::class);
        Queue::assertPushed(UpdateCommanderArea::class);
        Queue::assertPushed(UpdateCommanderGroup::class);
        Queue::assertPushed(UpdateCommanderStub::class);
        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();
    }
}
