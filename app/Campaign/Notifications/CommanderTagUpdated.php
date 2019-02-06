<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderTagUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.tag";

    public $queue = 'sms';

    function params(Contact $notifiable)
    {
        $code = strtoupper($notifiable->tags()->first()->code);

        return [
            'code' => $code,
            'next' => $code,
        ];
    }
}
