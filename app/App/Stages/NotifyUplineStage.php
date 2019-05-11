<?php

namespace App\App\Stages;

use App\Campaign\Notifications\CommanderReportUplineUpdated; //change the name

use Illuminate\Support\Arr;
use App\Campaign\Domain\Classes\{Command, CommandKey};
use App\Campaign\Notifications\CommanderTagUplineUpdated;
use App\Campaign\Notifications\CommanderAreaUplineUpdated;
use App\Campaign\Notifications\CommanderGroupUplineUpdated;
use App\Campaign\Notifications\CommanderAlertUplineUpdated;
use App\Campaign\Notifications\CommanderStatusUplineUpdated;
use App\Campaign\Notifications\CommanderCheckinUplineUpdated;
use App\Campaign\Notifications\CommanderRegistrationUplineUpdated;

class NotifyUplineStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::TAG      => CommanderTagUplineUpdated::class, //done
        CommandKey::AREA     => CommanderAreaUplineUpdated::class, //done
        CommandKey::GROUP    => CommanderGroupUplineUpdated::class, //done
        CommandKey::ALERT    => CommanderAlertUplineUpdated::class,
        CommandKey::REPORT   => CommanderReportUplineUpdated::class,
        CommandKey::CHECKIN  => CommanderCheckinUplineUpdated::class,
        CommandKey::STATUS   => CommanderStatusUplineUpdated::class, //done
        CommandKey::REGISTER => CommanderRegistrationUplineUpdated::class,
    ];

    protected function getNotifiable()
    {
        //TODO this is cheating, need to persist data before notification
        return  $this->getCommander()->parent ?? Arr::get($this->getParameters(), 'tagger');
    }

    public function setup($key)
    {
        Arr::set($this->params, 'downline', $this->getCommander());
        Arr::set($this->params, 'message', Arr::get($this->getParameters(), 'message'));
    }
}
