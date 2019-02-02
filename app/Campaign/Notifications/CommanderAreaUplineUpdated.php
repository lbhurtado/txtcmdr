<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderAreaUplineUpdated extends BaseNotification
{
    protected $downline;

    protected $template = "txtcmdr.upline.area";

    public function __construct(Contact $downline)
    {
        $this->downline = $downline;
    }

    function params(Contact $notifiable)
    {
        $area = $this->downline->areas()->first()->qn;
        $handle = $this->downline->handle;
        $mobile = $this->downline->mobile;

        return [
            'handle' => $handle,
            'mobile' => $mobile,
            'area' => $area,
        ];
    }
}