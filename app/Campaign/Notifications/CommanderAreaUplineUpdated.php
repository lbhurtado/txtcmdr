<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderAreaUplineUpdated extends BaseNotification
{
    protected $template = "txtcmdr.upline.area";

    function params(Contact $notifiable)
    {
        $message = "The quick brown fox...";

        return compact('message');
    }
}