<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderStatusUplineUpdated extends BaseNotification
{
    protected $downline;

    protected $template = "txtcmdr.upline.status";
    
    public function __construct(Contact $downline)
    {
        $this->downline = $downline;
    }

    function params(Contact $notifiable)
    {
        $status = $this->downline->status;
        $reason = $this->downline->status()->reason ?? 'no reason';
        $handle = $this->downline->handle;
        $mobile = $this->downline->mobile;

        return [
            'handle' => $handle,
            'mobile' => $mobile,
            'status' => $status,
            'reason' => $reason,
        ];
    }
}
