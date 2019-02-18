<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\InfoKey;
use App\Campaign\Notifications\Info\CommanderInfoTagUpdated;
use App\Campaign\Notifications\Info\CommanderInfoAreaUpdated;
use App\Campaign\Notifications\Info\CommanderInfoGroupUpdated;
use App\Campaign\Notifications\Info\CommanderInfoAlertUpdated;
use App\Campaign\Notifications\Info\CommanderInfoStatusUpdated;
use App\Campaign\Notifications\Info\CommanderInfoDownlinesUpdated;
use App\Campaign\Notifications\Info\CommanderInfoDescendantsUpdated;
use App\Missive\Domain\Models\Contact;

class NotifyCommanderInfoStage extends NotifyStage
{
    protected $notifications = [
        InfoKey::TAG => CommanderInfoTagUpdated::class,
        InfoKey::AREA => CommanderInfoAreaUpdated::class,
        InfoKey::GROUP => CommanderInfoGroupUpdated::class,
        InfoKey::ALERT => CommanderInfoAlertUpdated::class,
        InfoKey::STATUS => CommanderInfoStatusUpdated::class,
        InfoKey::DOWNLINES => CommanderInfoDownlinesUpdated::class,
        InfoKey::DESCENDANTS => CommanderInfoDescendantsUpdated::class,
    ];

    protected function getNotification()
    {
        $keyword = strtoupper(array_get($this->parameters, 'keyword'));
    	$key = array_get(array_flip(config('txtcmdr.infokeys')), $keyword); //update this always
        $this->setup($key); //TODO: make this elegant

        return array_get($this->notifications, $key);
    }

    protected function getNotifiable()
    {
        return $this->getCommander();
    }

    public function setup($key)
    {
        $this->params = [
            'context' => null
        ];
    }
}
