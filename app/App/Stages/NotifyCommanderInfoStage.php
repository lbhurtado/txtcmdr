<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\InfoKey;
use App\Campaign\Notifications\Info\CommanderInfoAlertUpdated;
use App\Campaign\Notifications\Info\CommanderInfoAreaUpdated;
use App\Campaign\Notifications\Info\CommanderInfoGroupUpdated;
use App\Campaign\Notifications\Info\CommanderInfoTagUpdated;

class NotifyCommanderInfoStage extends NotifyStage
{
    protected $notifications = [
        InfoKey::TAG => CommanderInfoTagUpdated::class,
        InfoKey::AREA => CommanderInfoAreaUpdated::class,
        InfoKey::GROUP => CommanderInfoGroupUpdated::class,
        InfoKey::ALERT => CommanderInfoAlertUpdated::class,
    ];

    protected function getNotification()
    {
        $keyword = strtoupper(array_get($this->parameters, 'keyword'));
    	$key = array_get(array_flip(config('txtcmdr.infokeys')), $keyword);

        return array_get($this->notifications, $key);
    }

    protected function getNotifiable()
    {
        return $this->getCommander();
    }
}