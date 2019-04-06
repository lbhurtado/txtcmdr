<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderConfirmUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.confirm";

    public $queue = 'sms';

    function params(Contact $notifiable)
    {
        $first_name = ucfirst(array_first(explode(' ', $notifiable->handle)));

        return [
            'handle' => $first_name,
        ];
    }
}