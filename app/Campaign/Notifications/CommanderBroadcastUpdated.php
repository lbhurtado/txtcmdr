<?php

namespace App\Campaign\Notifications;


class CommanderBroadcastUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.broadcast";

    function params($notifiable)
    {
        $message = "The quick brown fox...";

        return compact('message');
    }
}