<?php

namespace App\Campaign\Notifications;

use Illuminate\Support\Arr;
use App\Missive\Domain\Models\Contact;

class CommanderRegistrationUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.registration";

    public $queue = 'sms';

    function params(Contact $notifiable)
    {
        $first_name = ucfirst(Arr::first(explode(' ', $notifiable->handle)));

        return [
            'handle' => $first_name,
        ];
    }
}
