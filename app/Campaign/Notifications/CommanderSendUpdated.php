<?php

namespace App\Campaign\Notifications;


class CommanderSendUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.send";

    function params($notifiable)
    {
        $message = "The quick brown fox...";

        return compact('message');
    }
}
