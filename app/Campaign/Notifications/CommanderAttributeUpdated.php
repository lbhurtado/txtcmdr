<?php

namespace App\Campaign\Notifications;

class CommanderAttributeUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.alert";

    function params($notifiable)
    {
        $attribute = "custom";

        return compact('attribute');
    }
}