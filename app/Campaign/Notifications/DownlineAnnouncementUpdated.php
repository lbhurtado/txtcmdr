<?php

namespace App\Campaign\Notifications;

class DownlineAnnouncementUpdated extends BaseNotification
{
    protected $template = "txtcmdr.downline.announcement";

    function params($notifiable)
    {
        $message = "The quick brown fox...";

        return compact('message');
    }
}
