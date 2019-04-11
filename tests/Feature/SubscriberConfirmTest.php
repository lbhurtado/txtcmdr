<?php

namespace Tests\Feature;

use App\Missive\Jobs\UpdateContact;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Jobs\{UpdateCommanderArea, UpdateCommanderGroup};
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Campaign\Notifications\CommanderConfirmUpdated;

class SubscriberConfirmTest extends TestCase
{
    use DatabaseTransactions;

    protected $id;

    protected $handle;

    protected $default_excel_file = null;

    public function setUp(): void
    {
        parent::setUp();

        $record = $this->getRandomRecord(); 

        $this->id = $record['id'];
        $this->handle = $record['name'];

        $this->id = '10801';
        $this->handle = 'John Doe';

    }

    /** @test */
    public function commander_confirm_stages()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::CONFIRM);
        $missive = "RUTH {$this->id} John Doe";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

         /*** assert ***/
        $this->assertCommandIssued($missive);

        Queue::assertPushed(UpdateContact::class);
        Queue::assertPushed(UpdateCommanderArea::class);
        Queue::assertPushed(UpdateCommanderGroup::class);
        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();           
     }

    // /** @test */
    public function commander_confirm_handle()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::CONFIRM);
        $missive = "{$command} {$this->id}";

        /*** act ***/
        Queue::fake();
        $this->redefineRoutes();
        (new UpdateContact($this->commander, $this->handle))->handle();

         /*** assert ***/
        $this->assertCommandIssued($missive);
        $this->assertEquals($this->commander->handle, $this->handle);            
     }

     protected function getRandomRecord()
     {
        $array = excel_range_to_array($this->default_excel_file, ['id', 'name', 'area', 'group']);

        return $array[array_rand($array)];
     }
}
