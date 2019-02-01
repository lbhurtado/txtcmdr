<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\{Command, CommandKey};
use App\Campaign\Notifications\DescendantsBroadcastUpdated;

class NotifyDescendantsStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::BROADCAST => DescendantsBroadcastUpdated::class,
    ];

    protected function getNotifiable()
    {
        return $this->getCommander()->descendants();
    }
}