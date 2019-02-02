<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderTagUplineUpdated extends BaseNotification
{
    protected $downline;

    protected $template = "txtcmdr.upline.tag";

    public function __construct(Contact $downline)
    {
        $this->downline = $downline;
    }

    function params(Contact $notifiable)
    {
        $code = strtoupper($this->downline->tags()->first()->code);
        $handle = $this->downline->handle;
        $mobile = $this->downline->mobile;

        return [
            'handle' => $handle,
            'mobile' => $mobile,
            'code' => $code,
        ];
    }
}
