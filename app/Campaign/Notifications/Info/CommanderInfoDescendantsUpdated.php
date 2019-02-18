<?php

namespace App\Campaign\Notifications\Info;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Notifications\BaseNotification;

class CommanderInfoDescendantsUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.info.descendants";

    function params(Contact $notifiable)
    {
        $data = $notifiable->descendants->count();

        return compact('data');
    }
}