<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Notifications\CommanderSendToGroup;

class NotifyContextGroupStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::SEND => CommanderSendToGroup::class,
    ];

    protected function getNotifiable()
    {
        return optional($this->getCommander()->groups()->first(), function ($group) {
        	return $group->contacts()->where('id', '!=', $this->getCommander()->id)->get();
        });
    }
}