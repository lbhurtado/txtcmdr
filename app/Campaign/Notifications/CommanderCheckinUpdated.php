<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderCheckinUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.checkin";

    public $queue = 'checkin';

    function params(Contact $notifiable)
    {
        $location = 'location not yet available';
        $id = 0;

        optional($notifiable->latestCheckin()->first(), function ($checkin) use (&$location, &$id) {
            $location = $checkin->mapUrl;
            $id = $checkin->id;
        });

        return [
            'id' => $id,
            'location' => $location,
        ];
    }
}
