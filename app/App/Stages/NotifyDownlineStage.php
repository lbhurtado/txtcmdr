<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\{Command, CommandKey};
use App\Campaign\Notifications\DownlineAnnouncementUpdated;

class NotifyDownlineStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::ANNOUNCE => DownlineAnnouncementUpdated::class,
    ];

    protected function getNotifiable()
    {
        return $this->getCommander()->downlines()->get();
    }
}