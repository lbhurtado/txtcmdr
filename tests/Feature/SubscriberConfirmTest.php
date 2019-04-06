<?php

namespace Tests\Feature;

// use Tests\TestCase;
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
    
    /** @test */
    function commander_confirm_id_command()
    {
        /*** arrange ***/
        $this->conjureContact();
        $record = $this->getRandomRecord(); 
        $id = $record[0];
        $handle = $record[1];
        
        $command = $this->getCommand(CommandKey::CONFIRM);
        $missive = "{$command} {$id}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();
        //the ff: line is needed to make sure that UpdateContact job is pushed

         /*** assert ***/
        $this->assertCommandIssued($missive);

        Queue::assertPushed(UpdateContact::class);
        Queue::assertPushed(UpdateCommanderArea::class);
        Queue::assertPushed(UpdateCommanderGroup::class);
        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();
     
        (new UpdateContact($this->commander, $handle))->handle();
        $this->assertEquals($this->commander->handle, $handle);             
     }

     protected function getRandomRecord()
     {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load("volunteers.xlsx");
        
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

        $array = $worksheet->rangeToArray("A2:{$highestColumn}{$highestColumnIndex}");

        return $array[array_rand($array)];
     }
}
