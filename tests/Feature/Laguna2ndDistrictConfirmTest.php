<?php

namespace Tests\Feature;

use App\Missive\Jobs\UpdateContact;
use App\Campaign\Domain\Models\Lead;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Jobs\UpdateCommanderLead;
use App\Campaign\Domain\Classes\CommandKey;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\CommanderConfirmUpdated;
use App\Campaign\Jobs\{UpdateCommanderArea, UpdateCommanderGroup, UpdateCommanderTag};

class Laguna2ndDistrictConfirmTest extends TestCase
{
    protected $keyword;

    function setup(): void
    {
        parent::setup();

        $this->keyword = $this->getCommand(CommandKey::CONFIRM);
    }

    /** @test */
    public function commander_can_confirm_using_syntax_code_existing_numeric_id_and_with_name()
    {
        /*** arrange ***/
        $lead = Lead::all()->random();
        $name = $this->faker->name;
        $missive = "{$this->keyword} {$lead->code} {$name}";

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
        Queue::assertPushed(UpdateCommanderTag::class, function ($job) use ($lead) {
            return $job->commander->is($this->commander) && $job->code == $lead->code;
        });
        Queue::assertPushed(UpdateCommanderArea::class, function ($job) use ($lead) {
            return $job->commander->is($this->commander) && strtoupper($job->area->name) == strtoupper($lead->area);
        });
        Queue::assertPushed(UpdateCommanderGroup::class, function ($job) use ($lead) {
            return $job->commander->is($this->commander) && $job->group->name == $lead->group;
        });
        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_can_confirm_using_syntax_code_existing_numeric_id_and_with_name_no_spaces()
    {
        /*** arrange ***/
        $lead = Lead::all()->random();
        $name = $this->faker->name;
        $missive = "{$this->keyword}{$lead->code}{$name}";

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
            return $job->commander->is($this->commander) && strtoupper($job->area->name) == strtoupper($lead->area);
        });
        Queue::assertPushed(UpdateCommanderGroup::class, function ($job) use ($lead) {
            return $job->commander->is($this->commander) && $job->group->name == $lead->group;
        });
        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_can_confirm_using_syntax_code_existing_numeric_id_and_with_name_and_gibberish_in_between()
    {
        /*** arrange ***/
        $lead = Lead::all()->random();
        $name = $this->faker->name;
        $missive = " %# {$this->keyword}!@#{$lead->code} ^&*( {$name} *()";

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
            return $job->commander->is($this->commander) && strtoupper($job->area->name) == strtoupper($lead->area);
        });
        Queue::assertPushed(UpdateCommanderGroup::class, function ($job) use ($lead) {
            return $job->commander->is($this->commander) && $job->group->name == $lead->group;
        });
        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_can_confirm_using_syntax_code_non_existing_numeric_id_and_with_name()
    {
        /*** arrange ***/
        $non_existing_id = '1000000';
        $name = $this->faker->name;
        $missive = "{$this->keyword} {$non_existing_id} {$name}";

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
        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_can_confirm_using_syntax_code_without_numeric_id_and_with_name()
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
        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_can_confirm_using_syntax_code_without_numeric_id_and_without_name()
    {
        /*** arrange ***/
        $missive = "{$this->keyword}";

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
        Notification::assertSentTo($this->commander, CommanderConfirmUpdated::class);
        $this->assertAirtimeCharged();
    }

    /** @test */
    public function commander_cannot_confirm_using_syntax_without_code_with_numeric_id_and_with_name()
    {
        /*** arrange ***/
        $lead = Lead::all()->random();
        $name = $this->faker->name;
        $missive = "{$lead->code} {$name}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Queue::assertNotPushed(UpdateCommanderLead::class);
        Queue::assertNotPushed(UpdateCommanderArea::class);
        Queue::assertNotPushed(UpdateCommanderGroup::class);
        Notification::assertNotSentTo($this->commander, CommanderConfirmUpdated::class);
    }
}
