<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderLocationUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.checkin";

    function params(Contact $notifiable)
    {
//        $location = $notifiable->checkins()->first()->mapUrl;

        $location = 'This is is the location';

        return compact('location');
    }
}
