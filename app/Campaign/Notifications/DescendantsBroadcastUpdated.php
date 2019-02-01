<?php

namespace App\Campaign\Notifications;


class DescendantsBroadcastUpdated extends BaseNotification
{
    protected $template = "txtcmdr.descendants.broadcast";

    function params($notifiable)
    {
        $message = "The quick brown fox...";

        return compact('message');
    }
}