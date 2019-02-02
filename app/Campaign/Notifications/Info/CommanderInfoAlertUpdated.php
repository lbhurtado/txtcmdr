<?php

namespace App\Campaign\Notifications\Info;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Notifications\BaseNotification;

class CommanderInfoAlertUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.info.alert";

    function params(Contact $notifiable)
    {
        $alert = $notifiable->groups()->first()->alerts()->first();
        $data = $alert ? "{$alert->name}" : 'none';

        return compact('data');
    }
}