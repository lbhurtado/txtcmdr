<?php

namespace App\Campaign\Notifications;

class CommanderAlertUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.alert";

    function params($notifiable)
    {
        $alert = "custom";

        return compact('alert');
    }
}