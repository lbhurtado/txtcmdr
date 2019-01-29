<?php

namespace App\Campaign\Notifications;

class CommanderAttributeUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.attribute";

    function params($notifiable)
    {
        $attribute = "custom";

        return compact('attribute');
    }
}