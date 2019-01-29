<?php

namespace App\Campaign\Notifications;

class CommanderTagUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.tag";

    function params($notifiable)
    {
        $code = $notifiable->tags()->first()->code;

        return compact('code');
    }
}
