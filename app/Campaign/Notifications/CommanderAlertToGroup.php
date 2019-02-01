<?php

namespace App\Campaign\Notifications;

class CommanderAlertToGroup extends BaseNotification
{
    protected $template = "txtcmdr.alert.group";

    function params($notifiable)
    {
        $message = "The quick brown fox...";

        return compact('message');
    }
}
