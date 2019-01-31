<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Missive\Jobs\UpdateContact;
use App\Campaign\Notifications\CommanderRegistrationUpdated;
use App\Campaign\Domain\Classes\CommandKey;

class SubscriberRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $code;

    function setup()
    {
        parent::setUp();
        $command = $this->getCommand(CommandKey::TAG);
        $code = $this->faker->word;
        $campaign = $this->conjureCampaign();
        $missive = "{$campaign->name}{$command}{$code}";
        $this->redefineRoutes();
        $this->assertCommandIssued($missive);

        $this->code = $code;
    }

    /** @test */
    function commander_can_send_registration_command()
    {
        /*** arrange ***/
//        $tag = $this->conjureTag();
        $handle = $this->faker->name;
        $missive = "{$this->code} {$handle}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->redefineRoutes();
//        Notification::assertSentTo($this->commander, CommanderRegistrationUpdated::class);
//        Queue::assertPushed(UpdateContact::class);
        Queue::assertPushed(ChargeAirtime::class);
     }
}
