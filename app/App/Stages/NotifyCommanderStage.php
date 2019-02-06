<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Notifications\CommanderTagUpdated;
use App\Campaign\Notifications\CommanderSendUpdated;
use App\Campaign\Notifications\CommanderAreaUpdated;
use App\Campaign\Notifications\CommanderTestUpdated;
use App\Campaign\Notifications\CommanderHelpUpdated;
use App\Campaign\Notifications\CommanderOptinUpdated;
use App\Campaign\Notifications\CommanderGroupUpdated;
use App\Campaign\Notifications\CommanderAlertUpdated;
use App\Campaign\Notifications\CommanderReportUpdated;
use App\Campaign\Notifications\CommanderStatusUpdated;
use App\Campaign\Notifications\CommanderCheckinUpdated;
use App\Campaign\Notifications\CommanderAttributeUpdated;
use App\Campaign\Notifications\CommanderBroadcastUpdated;
use App\Campaign\Notifications\CommanderRegistrationUpdated;
use App\Campaign\Notifications\CommanderAnnouncementUpdated;

class NotifyCommanderStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::TAG       => CommanderTagUpdated::class,
        CommandKey::SEND      => CommanderSendUpdated::class,
        CommandKey::AREA      => CommanderAreaUpdated::class,
        CommandKey::TEST      => CommanderTestUpdated::class,
        CommandKey::HELP      => CommanderHelpUpdated::class,
        CommandKey::GROUP     => CommanderGroupUpdated::class,
        CommandKey::ALERT     => CommanderAlertUpdated::class,
        CommandKey::OPTIN     => CommanderOptinUpdated::class,
        CommandKey::REPORT    => CommanderReportUpdated::class,
        CommandKey::STATUS    => CommanderStatusUpdated::class,
        CommandKey::CHECKIN   => CommanderCheckinUpdated::class,
        CommandKey::REGISTER  => CommanderRegistrationUpdated::class,
        CommandKey::ANNOUNCE  => CommanderAnnouncementUpdated::class,
        CommandKey::ATTRIBUTE => CommanderAttributeUpdated::class,
        CommandKey::BROADCAST => CommanderBroadcastUpdated::class,
    ];

    protected function getNotifiable()
    {
        return $this->getCommander();
    }

    public function setup($key)
    {
        $args = array_get($this->getParameters(), 'args');

        array_set($this->params, 'message', array_get($this->getParameters(), 'message'));
        array_set($this->params, 'count', array_get($args, 'count', 1));
        array_set($this->params, 'context', array_get($args, 'context'));
    }
}
