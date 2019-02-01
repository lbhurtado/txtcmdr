<?php

namespace App\Campaign\Notifications;

class CommanderSendToGroup extends BaseNotification
{
    protected $template = "txtcmdr.send.group";

    function params($notifiable)
    {
        $message = "The quick brown fox...";

        return compact('message');
    }
}