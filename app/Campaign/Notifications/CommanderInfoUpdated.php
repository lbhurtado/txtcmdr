<?php

namespace App\Campaign\Notifications;

class CommanderInfoUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.info";

    function params($notifiable)
    {
        $info = implode(array_values(config('txtcmdr.infokeys')),', ');

        return compact('info');
    }
}
