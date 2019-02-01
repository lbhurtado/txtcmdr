<?php

namespace App\Campaign\Notifications;


class UplineReportUpdated extends BaseNotification
{
    protected $template = "txtcmdr.upline.report";

    function params($notifiable)
    {
        $message = "The quick brown fox...";

        return compact('message');
    }
}
