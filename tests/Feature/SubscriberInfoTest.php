<?php

namespace Tests\Feature;

use App\Charging\Jobs\ChargeAirtime;
use App\Campaign\Domain\Classes\InfoKey;
use Tests\TextCommanderCase as TestCase;
use App\Campaign\Domain\Classes\CommandKey;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Queue, Notification};
use App\Campaign\Notifications\Info\CommanderInfoTagUpdated;
use App\Campaign\Notifications\Info\CommanderInfoAreaUpdated;
use App\Campaign\Notifications\Info\CommanderInfoGroupUpdated;
use App\Campaign\Notifications\Info\CommanderInfoAlertUpdated;

class SubscriberInfoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $infoCommand;

    protected $infoKeys;

    protected $notifications;

    function setup()
    {
        parent::setUp();

        $this->infoCommand = $this->getCommand(CommandKey::INFO) == '\?' ? '?' : $this->getCommand(CommandKey::INFO);

        $this->infoKeys = config('txtcmdr.infokeys');

        $this->notifications = [
            InfoKey::TAG => CommanderInfoTagUpdated::class,
            InfoKey::AREA => CommanderInfoAreaUpdated::class,
            InfoKey::GROUP => CommanderInfoGroupUpdated::class,
            InfoKey::ALERT => CommanderInfoAlertUpdated::class,
        ];
    }

    /** @test */
    function commander_can_send_info_command()
    {
        foreach ($this->notifications as $key => $notification) {
            /*** arrange ***/
            $command = $this->infoCommand;
            $keyword = array_get($this->infoKeys, $key);
            $missive = "{$command}{$keyword}";

            /*** act ***/
            $this->redefineRoutes();
            Queue::fake();
            Notification::fake();

            /*** assert ***/
            $this->assertCommandIssued($missive);
            Notification::assertSentTo($this->commander, $notification);
            Queue::assertPushed(ChargeAirtime::class);
        }
    }
}
