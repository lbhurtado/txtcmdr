<?php

namespace App\Campaign\Notifications;

class CommanderInfoUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.info";

    function params($notifiable)
    {
        $info = "si vis pacem para bellum";

        return compact('info');
    }
}
