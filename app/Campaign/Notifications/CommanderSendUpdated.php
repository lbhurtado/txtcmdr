<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderSendUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.send.feedback";

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
            'count' => '25',
        ];
    }
}
