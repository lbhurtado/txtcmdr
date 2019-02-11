<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderReportUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.report";

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
            'upline' => $notifiable->parent->handle,
        ];
    }
}
