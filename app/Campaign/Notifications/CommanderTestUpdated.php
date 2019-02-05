<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderTestUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.test";

    function params(Contact $notifiable)
    {
        return [];
    }
}
