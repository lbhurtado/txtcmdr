<?php

namespace App\Campaign\Notifications;

class CommanderStatusUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.status";

    function params($notifiable)
    {
        $status = "custom";

        return compact('status');
    }
}