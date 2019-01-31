<?php

namespace App\Campaign\Notifications;

class CommanderStatusUplineUpdated extends BaseNotification
{
    protected $template = "txtcmdr.upline.status";

    function params($notifiable)
    {
        $status = "custom";

        return compact('status');
    }
}
