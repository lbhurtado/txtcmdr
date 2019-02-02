<?php

namespace App\Campaign\Notifications;

class CommanderInfoUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.info";

    function params($notifiable)
    {

        $payload = array_get($notifiable->extra_attributes, 'payload', ['AREA' => 'Magallanes']);
        
        $key = 'AREA';
        $value = array_get($payload, $key, 'nowhere');

        return compact('key', 'value');
    }
}
