<?php

namespace App\Campaign\Notifications;

class CommanderGroupUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.group";

    function params($notifiable)
    {
        $group = $notifiable->groups()->first()->qn;

        return compact('group');
    }
}
