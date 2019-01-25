<?php

namespace App\App\Stages;

use App\Campaign\Notifications\CommanderTagUpdated;
use App\Campaign\Notifications\CommanderAreaUpdated;
use App\Campaign\Notifications\CommanderGroupUpdated;

class NotifyCommanderStage extends BaseStage
{
    protected $notifications = [
        '#' => CommanderTagUpdated::class,
        '@' => CommanderAreaUpdated::class,
        '&' => CommanderGroupUpdated::class,
    ];

    public function execute()
    {
        optional($this->getNotification(), function ($notification) {
            $this->getCommander()->notify(app($notification));
        });
    }
}