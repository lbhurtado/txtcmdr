<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\{Command, CommandKey};
use App\Campaign\Notifications\DownlineAnnouncementUpdated;
use App\Campaign\Notifications\DescendantsBroadcastUpdated;

class NotifyDownlineStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::ANNOUNCE => DownlineAnnouncementUpdated::class,
//        CommandKey::BROADCAST => DescendantsBroadcastUpdated::class,
    ];

    protected function getNotifiable()
    {
        return $this->getCommander()->children()->get();
    }

    public function setup($key)
    {
        $this->params = [
            'message' => array_get($this->getParameters(), 'message')
        ];
    }
}
