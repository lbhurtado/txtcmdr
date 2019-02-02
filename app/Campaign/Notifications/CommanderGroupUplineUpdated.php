<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderGroupUplineUpdated extends BaseNotification
{
    protected $downline;

    protected $template = "txtcmdr.commander.group";

    public function __construct(Contact $downline)
    {
        $this->downline = $downline;
    }

    function params(Contact $notifiable)
    {
        $group = $notifiable->groups()->first()->qn;

        $downline = $this->downline->handle;

        return compact('group','downline');
    }
}

