<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderPollUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.poll";

    public $queue = 'sms';

    function params(Contact $notifiable)
    {
        $first_name = ucfirst(Arr::first(explode(' ', $notifiable->handle)));

        return [
            'handle' => $first_name,
        ];
    }
}
