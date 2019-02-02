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
        CommandKey::TAG      => CommanderTagUplineUpdated::class,
        CommandKey::AREA     => CommanderAreaUplineUpdated::class,
        CommandKey::GROUP    => CommanderGroupUplineUpdated::class,
        CommandKey::ALERT    => CommanderAlertUplineUpdated::class,
        CommandKey::REPORT   => UplineReportUpdated::class,
        CommandKey::STATUS   => CommanderStatusUplineUpdated::class,
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