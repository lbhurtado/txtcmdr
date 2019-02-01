<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Campaign\Notifications\CommanderInfoUpdated;
use Illuminate\Support\Facades\{Queue, Notification};

class SubscriberInfoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    function commander_can_send_info_command()
    {
        /*** arrange ***/
        $command = $this->getCommand(CommandKey::INFO) == '\?' ? '?' : $this->getCommand(CommandKey::INFO);
        $keyword = $this->faker->word;
        $missive = "{$command}{$keyword}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        Notification::assertSentTo($this->commander, CommanderInfoUpdated::class);
        Queue::assertPushed(ChargeAirtime::class);
    }
}
