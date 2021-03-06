<?php

namespace App\Campaign\Notifications\Info;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Notifications\BaseNotification;

class CommanderInfoAreaUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.info.area";

    function params(Contact $notifiable)
    {
        $area = $notifiable->areas()->first();
        $data = $area ? "{$area->qn}" : 'none';

        return compact('data');
    }
}
