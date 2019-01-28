<?php

namespace App\App\Stages;

use App\Campaign\Notifications\CommanderTagUpdated;
use App\Campaign\Notifications\CommanderSendUpdated;
use App\Campaign\Notifications\CommanderAreaUpdated;
use App\Campaign\Notifications\CommanderInfoUpdated;
use App\Campaign\Notifications\CommanderOptinUpdated;
use App\Campaign\Notifications\CommanderGroupUpdated;
use App\Campaign\Notifications\CommanderAlertUpdated;
use App\Campaign\Domain\Classes\{Command, CommandKey};
use App\Campaign\Notifications\CommanderReportUpdated;
use App\Campaign\Notifications\CommanderRegistrationUpdated;
use App\Campaign\Notifications\CommanderAnnouncementUpdated;

class NotifyCommanderStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::TAG      => CommanderTagUpdated::class,
        CommandKey::SEND     => CommanderSendUpdated::class,
        CommandKey::AREA     => CommanderAreaUpdated::class,
        CommandKey::INFO     => CommanderInfoUpdated::class,
        CommandKey::GROUP    => CommanderGroupUpdated::class,
        CommandKey::ALERT    => CommanderAlertUpdated::class,
        CommandKey::OPTIN    => CommanderOptinUpdated::class,
        CommandKey::REPORT   => CommanderReportUpdated::class,
        CommandKey::REGISTER => CommanderRegistrationUpdated::class,
        CommandKey::ANNOUNCE => CommanderAnnouncementUpdated::class,
    ];

    protected function getNotifiable()
    {
        return $this->getCommander();
    }
}