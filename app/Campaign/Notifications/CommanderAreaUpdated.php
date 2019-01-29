<?php

namespace App\Campaign\Notifications;

class CommanderAreaUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.area";

    function params($notifiable)
    {
        $area = $notifiable->areas()->first()->qn;
        $signature = config('txtcmdr.notification.signature');

        return compact('area', 'signature');
    }
}
