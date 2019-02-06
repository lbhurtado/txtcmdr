<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Contracts\CampaignContext;

class CommanderSendUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.send.feedback";

    protected $message;

    protected $count;

    protected $context;

    public function __construct($message, $count, CampaignContext $context)
    {
        $this->message = $message;
        $this->count = $count;
        $this->context = $context;
    }

    function params(Contact $notifiable)
    {
        $tease = string($this->message)->tease(10);

        $context = optional($this->context)->qn;

        return [
            'tease' => $tease,
            'count' => $this->count,
            'context' => $context,
        ];
    }
}
