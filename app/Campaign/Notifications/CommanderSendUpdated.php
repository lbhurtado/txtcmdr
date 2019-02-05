<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderSendUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.send.feedback";

    protected $message;

    protected $count;

    public function __construct($message, $count)
    {
        $this->message = $message;
        $this->count = $count;
    }

    function params(Contact $notifiable)
    {
        $tease = string($this->message)->tease(10);

        return [
            'tease' => $tease,
            'count' => $this->count,
        ];
    }
}
