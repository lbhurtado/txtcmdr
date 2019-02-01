<?php

namespace App\Campaign\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommanderReportUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.report";

    function params($notifiable)
    {
        $message = "The quick brown fox...";

        return compact('message');
    }
}
