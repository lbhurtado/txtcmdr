<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderCheckinUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.checkin";

    public $queue = 'checkin';

    function params(Contact $notifiable)
    {
        $location = optional($notifiable->checkins()->first())->mapUrl ?? 'location not yet available';

        return compact('location');
    }
}
