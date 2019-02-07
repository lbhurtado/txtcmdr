<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Contracts\CampaignContext;

class CommanderTagUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.tag";

    public $queue = 'sms';

    protected $context;

    public function __construct(CampaignContext $context)
    {
        $this->context = $context;
    }

    function params(Contact $notifiable)
    {
        $code = strtoupper($notifiable->tag->code);
        $globe = trans('txtcmdr.sms.telcos.globe');
        $smart = trans('txtcmdr.sms.telcos.smart');

        return [
            'context' => $this->context->title,
            'code' => $code,
            'numbers' => "either \nGlobe ({$globe}) or \nSmart ({$smart})",
        ];
    }
}
