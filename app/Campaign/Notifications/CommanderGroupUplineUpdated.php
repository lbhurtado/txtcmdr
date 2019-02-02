<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderGroupUplineUpdated extends BaseNotification
{
    protected $downline;

    protected $template = "txtcmdr.upline.group";

    public function __construct(Contact $downline)
    {
        $this->downline = $downline;
    }

    function params(Contact $notifiable)
    {
        $group = $this->downline->groups()->first()->qn;
        $handle = $this->downline->handle;
        $mobile = $this->downline->mobile;

        return [
            'handle' => $handle,
            'mobile' => $mobile,
            'group' => $group,
        ];
    }
}

