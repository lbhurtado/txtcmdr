<?php

namespace App\Campaign\Notifications;

class CommanderRegistrationUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.registration";

    function params($notifiable)
    {
        $handle = $notifiable->handle;

        return compact('handle');
    }
}
