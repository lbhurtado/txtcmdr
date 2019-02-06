<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Contracts\CampaignContext;

class CommanderSendToGroup extends BaseNotification
{
    protected $template = "txtcmdr.commander.send.group";

    protected $context;

    protected $message;

    public function __construct(CampaignContext $context, $message)
    {
        $this->context = $context;
        $this->message = $message;
    }

    function params(Contact $notifiable)
    {
        return [
            'group' => $this->context->qn,
            'message' => $this->message,
        ];
    }
}

