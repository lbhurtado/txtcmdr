<?php

namespace App\Campaign\Notifications\Info;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Notifications\BaseNotification;

class CommanderInfoStatusUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.info.status";

    function params(Contact $notifiable)
    {
        $data = $notifiable->status;

        return compact('data');
    }
}
