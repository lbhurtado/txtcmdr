<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderGroupUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.group";

    function params(Contact $notifiable)
    {
        $group = $notifiable->groups()->first()->qn;

        return compact('group');
    }
}
