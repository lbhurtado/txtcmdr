<?php

namespace App\Campaign\Notifications\Info;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Notifications\BaseNotification;

class CommanderInfoDownlinesUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.info.downlines";

    protected $context;

    public function __construct(Contact $context = null)
    {
        $this->context = $context;
    }

    function params(Contact $notifiable)
    {
//        $data = $notifiable->children->count();
        $data = ($this->context ?? $notifiable)->children->count();

        return [
            'context' => optional($this->context)->handle ?? 'You',
            'data' => $data,
        ];
    }
}