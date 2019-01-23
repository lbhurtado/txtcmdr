<?php

namespace App\App\Stages;

use App\Campaign\Notifications\ContactAreaUpdated;
use App\Campaign\Notifications\ContactGroupUpdated;

class NotifyCommanderStage extends BaseStage
{
    protected $notifications = [
        '@' => ContactAreaUpdated::class,
        '&' => ContactGroupUpdated::class,
    ];

    public function execute()
    {
        optional($this->getNotification(), function ($notification) {
            $this->getCommander()->notify(app($notification));
        });
    }
}