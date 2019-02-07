<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderAnnouncementUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.announce";

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    function params(Contact $notifiable)
    {
        $tease = string($this->message)->tease(10);

        return [
            'tease' => $tease,
            'count' => $notifiable->children()->count(),
        ];
    }
}

