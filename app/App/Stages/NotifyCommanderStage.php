<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Campaign\Notifications\CommanderTagUpdated;
use App\Campaign\Notifications\CommanderAreaUpdated;
use App\Campaign\Notifications\CommanderGroupUpdated;
use App\Campaign\Notifications\CommanderRegistrationUpdated;
use App\Campaign\Domain\Classes\{Command, CommandKey};

class NotifyCommanderStage extends BaseStage
{
    protected $notifications = [
        CommandKey::TAG      => CommanderTagUpdated::class,
        CommandKey::AREA     => CommanderAreaUpdated::class,
        CommandKey::GROUP    => CommanderGroupUpdated::class,
        CommandKey::REGISTER => CommanderRegistrationUpdated::class,
    ];

    public function execute()
    {
        optional($this->getNotification(), function ($notification) {
            $this->getCommander()->notify(app($notification));
        });
    }

    protected function getNotification()
    {
        $cmd = $this->getParameters()['command'];
        $key = Command::$mappings[$cmd];

        return Arr::get($this->notifications, $key);
    }
}