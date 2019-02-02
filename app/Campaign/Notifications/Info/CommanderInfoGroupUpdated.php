<?php

namespace App\Campaign\Notifications\Info;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Notifications\BaseNotification;

class CommanderInfoGroupUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.info.group";

    function params(Contact $notifiable)
    {
        $group = $notifiable->groups()->first();
        $data = $group ? "{$group->name}" : 'none';

        return compact('data');
    }
}