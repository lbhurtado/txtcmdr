<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderAreaUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.area";

    function params(Contact $notifiable)
    {
        $area = $notifiable->areas()->first()->qn;

        return compact('area');
    }
}
