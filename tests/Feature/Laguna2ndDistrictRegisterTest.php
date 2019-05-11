<?php

namespace Tests\Feature;

use App\Missive\Jobs\UpdateContact;
use Tests\TextCommanderCase as TestCase;
use Illuminate\Support\Facades\{Queue, Notification};

class Laguna2ndDistrictRegisterTest extends TestCase
{
    protected $keyword;

    function setup(): void
    {
        parent::setup();

        $this->keyword = "C";
    }

    /** @test */
    public function commander_can_register_using_syntax_lgu_code_existing_clustered_precinct_id_and_with_name()
    {
        /*** arrange ***/
        $clustered_precinct_id = 17;
        $name = $this->faker->name;
        $missive = "{$this->keyword} {$clustered_precinct_id} {$name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
//        Queue::assertPushed(UpdateCommanderLead::class, function ($job) use ($lead) {
//            return $job->commander->is($this->commander) && $job->lead->is($lead);
//        });
        Queue::assertPushed(UpdateContact::class, function ($job) use ($name) {
            dd($job->handle);
            return $job->contact->is($this->commander) && $job->handle == $name;
        });
//        Queue::assertPushed(UpdateCommanderTag::class, function ($job) use ($lead) {
//            return $job->commander->is($this->commander) && $job->code == $lead->code;
//        });
//        Queue::assertPushed(UpdateCommanderArea::class, function ($job) use ($lead) {
//            return $job->commander->is($this->commander) && strtoupper($job->area->name) == strtoupper($lead->area);
//        });
//        Queue::assertPushed(UpdateCommanderGroup::class, function ($job) use ($lead) {
//            return $job->commander->is($this->commander) && $job->group->name == $lead->group;
//        });
//        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();
    }
}
