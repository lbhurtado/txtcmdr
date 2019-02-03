<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderAlertUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.alert";

    function params(Contact $notifiable)
    {
        $alert = strtoupper(optional($a = $notifiable->latest_alerts()->first())->name ?? 'no alert');
        $handle = optional($notifiable->upline)->handle ?? 'no upline';
        $groups = implode($a->groups()->get()->pluck('qn')->toArray(),', ');

        return [
            'alert' => $alert,
            'handle' => $handle,
            'groups' => $groups,
        ];
    }
}
