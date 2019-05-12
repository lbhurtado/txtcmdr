<?php

namespace Tests\Feature;

use App\Campaign\Domain\Models\Area;
use App\Missive\Jobs\UpdateContact;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Jobs\UpdateCommanderArea;
use App\Campaign\Jobs\UpdateCommanderGroup;
use App\Campaign\Notifications\CommanderRegistrationUpdated;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Jobs\UpdateCommanderIssues;
use App\Campaign\Notifications\CommanderPollUpdated;

class Laguna2ndDistrictRegisterTest extends TestCase
{
    protected $keyword;

    protected $area;

    function setup(): void
    {
        parent::setup();

        $this->area = Area::where('name', 'Cabuyao City')->first();

        $this->keyword = 'C';
    }

    /** @test */
    public function commander_can_register_using_syntax_lgu_code_existing_clustered_precinct_id_and_with_name()
    {
        /*** arrange ***/
        $name = $this->faker->name;
        $missive = "{$this->keyword} {$name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateContact::class, function ($job) use ($name) {
            return $job->contact->is($this->commander) && $job->handle == $name;
        });
        Queue::assertPushed(UpdateCommanderArea::class, function ($job) {
            return $job->commander->is($this->commander) && $job->area->is($this->area);
        });
        Notification::assertSentTo($this->commander, CommanderRegistrationUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_can_poll()
    {
        /*** arrange ***/
        $this->commander->syncAreas($this->area);
        $missive = "#47 RAMIL 200 ER 100";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);

        Queue::assertPushed(UpdateCommanderArea::class, function ($job) {
            $cluster = Area::where('name', 'CAB-47')->first();
            return $job->commander->is($this->commander) && $job->area->is($cluster);
        });
        Queue::assertPushed(UpdateCommanderIssues::class, function ($job) {
            return $job->commander->is($this->commander) && $job->poll_array == ['RAMIL' => 200, 'ER' => 100];
        });
//        Queue::assertPushed(UpdateCommanderArea::class, function ($job) {
//            return $job->commander->is($this->commander) && $job->area->is($this->area);
//        });
        Notification::assertSentTo($this->commander, CommanderPollUpdated::class);
        $this->assertAirtimeCharged();
    }
}
