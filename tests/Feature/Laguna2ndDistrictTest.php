<?php

namespace Tests\Feature;

use App\Missive\Jobs\UpdateContact;
use App\Campaign\Domain\Models\Lead;
use Tests\TextCommanderCase as TestCase;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderRegistrationUpdated;
use App\Campaign\Jobs\{UpdateCommanderArea, UpdateCommanderGroup};
use App\Campaign\Domain\Classes\CommandKey;
use App\App\Services\TextCommander;
use App\Campaign\Domain\Events\CommandExecuted;
use App\Campaign\Jobs\UpdateCommanderLead;

class Laguna2ndDistrictTest extends TestCase
{
    /** @test */
    public function commander_can_register_using_syntax_code_existing_numeric_id_and_with_name()
    {
        /*** arrange ***/
        $lead = Lead::all()->random();
        $name = $this->faker->name;
        $missive = "RUTH {$lead->code} {$name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateCommanderLead::class, function ($job) use ($lead) {
            return $job->commander->is($this->commander) && $job->lead->is($lead);
        });
        Queue::assertPushed(UpdateContact::class, function ($job) use ($name) {
            return $job->contact->is($this->commander) && $job->handle == $name;
        });
        Queue::assertPushed(UpdateCommanderArea::class, function ($job) use ($lead) {
            return $job->commander->is($this->commander) && $job->area->name == $lead->area;
        });
        Queue::assertPushed(UpdateCommanderGroup::class, function ($job) use ($lead) {
            return $job->commander->is($this->commander) && $job->group->name == $lead->group;
        });
        Notification::assertSentTo($this->commander, CommanderRegistrationUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_can_register_using_syntax_code_existing_numeric_id_and_with_name_no_spaces()
    {
        /*** arrange ***/
        $lead = Lead::all()->random();
        $name = $this->faker->name;
        $missive = "RUTH{$lead->code}{$name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateContact::class, function ($job) use ($name) {
            return $job->contact->is($this->commander) && $job->handle == $name;
        });
        Queue::assertPushed(UpdateCommanderArea::class, function ($job) use ($lead) {
            return $job->commander->is($this->commander) && $job->area->name == $lead->area;
        });
        Queue::assertPushed(UpdateCommanderGroup::class, function ($job) use ($lead) {
            return $job->commander->is($this->commander) && $job->group->name == $lead->group;
        });
        Notification::assertSentTo($this->commander, CommanderRegistrationUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_can_register_using_syntax_code_non_existing_numeric_id_and_with_name()
    {
        /*** arrange ***/
        $non_existing_id = '1000000';
        $name = $this->faker->name;
        $missive = "RUTH {$non_existing_id} {$name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateContact::class, function ($job) use ($name) {
            return $job->contact->is($this->commander) && $job->handle == $name;
        });
        optional(config('txtcmdr.default.area'), function ($default_area_name) {
            Queue::assertPushed(UpdateCommanderArea::class, function ($job) use ($default_area_name) {
                return $job->commander->is($this->commander) && strtoupper($job->area->name) == strtoupper($default_area_name);
            });
        });
        optional(config('txtcmdr.default.group'), function ($default_group_name) {
            Queue::assertPushed(UpdateCommanderGroup::class, function ($job) use ($default_group_name) {
                return $job->commander->is($this->commander) && strtoupper($job->group->name) == strtoupper($default_group_name);
            });
        });
        Notification::assertSentTo($this->commander, CommanderRegistrationUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_can_register_using_syntax_code_without_numeric_id_and_with_name()
    {
        /*** arrange ***/
        $name = $this->faker->name;
        $missive = "RUTH {$name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateContact::class, function ($job) use ($name) {
            return $job->contact->is($this->commander) && $job->handle == $name;
        });
        optional(config('txtcmdr.default.area'), function ($default_area_name) {
            Queue::assertPushed(UpdateCommanderArea::class, function ($job) use ($default_area_name) {
                return $job->commander->is($this->commander) && strtoupper($job->area->name) == strtoupper($default_area_name);
            });
        });
        optional(config('txtcmdr.default.group'), function ($default_group_name) {
            Queue::assertPushed(UpdateCommanderGroup::class, function ($job) use ($default_group_name) {
                return $job->commander->is($this->commander) && strtoupper($job->group->name) == strtoupper($default_group_name);
            });
        });
        Notification::assertSentTo($this->commander, CommanderRegistrationUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_can_register_using_syntax_code_without_numeric_id_and_without_name()
    {
        /*** arrange ***/
        $missive = "RUTH ";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertPushed(UpdateContact::class, function ($job) {
            return $job->contact->is($this->commander) && $job->handle == config('txtcmdr.default.handle');
        });
        optional(config('txtcmdr.default.area'), function ($default_area_name) {
            Queue::assertPushed(UpdateCommanderArea::class, function ($job) use ($default_area_name) {
                return $job->commander->is($this->commander) && strtoupper($job->area->name) == strtoupper($default_area_name);
            });
        });
        optional(config('txtcmdr.default.group'), function ($default_group_name) {
            Queue::assertPushed(UpdateCommanderGroup::class, function ($job) use ($default_group_name) {
                return $job->commander->is($this->commander) && strtoupper($job->group->name) == strtoupper($default_group_name);
            });
        });
        Notification::assertSentTo($this->commander, CommanderRegistrationUpdated::class);
        $this->assertAirtimeCharged();
    }
}
