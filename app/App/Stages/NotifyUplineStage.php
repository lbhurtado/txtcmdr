<?php

namespace App\App\Stages;

use App\Campaign\Notifications\UplineReportUpdated; //change the name


use App\Campaign\Domain\Classes\{Command, CommandKey};
use App\Campaign\Notifications\CommanderTagUplineUpdated;
use App\Campaign\Notifications\CommanderAreaUplineUpdated;
use App\Campaign\Notifications\CommanderGroupUplineUpdated;
use App\Campaign\Notifications\CommanderAlertUplineUpdated;
use App\Campaign\Notifications\CommanderStatusUplineUpdated;
use App\Campaign\Notifications\CommanderRegistrationUplineUpdated;

class NotifyUplineStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::TAG      => CommanderTagUplineUpdated::class, //done
        CommandKey::AREA     => CommanderAreaUplineUpdated::class, //done
        CommandKey::GROUP    => CommanderGroupUplineUpdated::class, //done
        CommandKey::ALERT    => CommanderAlertUplineUpdated::class,
        CommandKey::REPORT   => UplineReportUpdated::class,
        CommandKey::STATUS   => CommanderStatusUplineUpdated::class, //done
        CommandKey::REGISTER => CommanderRegistrationUplineUpdated::class,
    ];

    protected function getNotifiable()
    {
        return $this->getCommander()->upline;
    }

    public function setup($key)
    {
        $this->params = ['downline' => $this->getCommander()];
    }
}