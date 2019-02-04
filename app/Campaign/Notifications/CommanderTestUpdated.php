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

//    public function delay()
//    {
//        return 1;
//        return now()->addMinutes(1);
//
//    }
}
