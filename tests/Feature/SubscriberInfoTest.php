<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Campaign\Notifications\CommanderInfoUpdated;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Domain\Classes\InfoKey;

use App\Campaign\Notifications\Info\CommanderInfoAreaUpdated;

class SubscriberInfoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function setup()
    {
        parent::setUp();

        $this->infoCommand = $this->getCommand(CommandKey::INFO) == '\?' ? '?' : $this->getCommand(CommandKey::INFO);
        $this->randomKeywords = $this->faker->randomElement(InfoKey::getKeys());
    }

    /** @test */
    function commander_can_send_info_command()
    {
        /*** arrange ***/
        $command = $this->infoCommand;
        $keyword = $this->randomKeywords;
        $keyword = 'AREA';
        $missive = "{$command}{$keyword}";

        /*** act ***/
        $this->redefineRoutes();
        Queue::fake();
        Notification::fake();

        /*** assert ***/
        $this->assertCommandIssued($missive);
        // Notification::assertSentTo($this->commander, CommanderInfoUpdated::class);
        Notification::assertSentTo($this->commander, CommanderInfoAreaUpdated::class);
        Queue::assertPushed(ChargeAirtime::class);
    }
}
