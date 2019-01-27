<?php

namespace App\App\Stages;

use App\Campaign\Notifications\CommanderTagUpdated;
use App\Campaign\Notifications\CommanderSendUpdated;
use App\Campaign\Notifications\CommanderAreaUpdated;
use App\Campaign\Notifications\CommanderGroupUpdated;
use App\Campaign\Notifications\CommanderRegistrationUpdated;
use App\Campaign\Domain\Classes\{Command, CommandKey};

class NotifyCommanderStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::TAG      => CommanderTagUpdated::class,
        CommandKey::SEND     => CommanderSendUpdated::class,
        CommandKey::AREA     => CommanderAreaUpdated::class,
        CommandKey::GROUP    => CommanderGroupUpdated::class,
        CommandKey::REGISTER => CommanderRegistrationUpdated::class,
    ];

    protected function getNotifiable()
    {
        return $this->getCommander();
    }
}