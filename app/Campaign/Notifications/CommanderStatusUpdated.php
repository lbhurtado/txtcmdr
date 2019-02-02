<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderStatusUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.status";

    function params(Contact $notifiable)
    {
        $status = $notifiable->status;
        $reason = $notifiable->status()->reason ?? 'no reason';

        return [
            'status' => $status,
            'reason' => $reason,
        ];
    }
}