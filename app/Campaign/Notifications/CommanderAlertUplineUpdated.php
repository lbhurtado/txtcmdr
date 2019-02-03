<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderAlertUplineUpdated extends BaseNotification
{
    protected $downline;

    protected $template = "txtcmdr.upline.alert";

    public function __construct(Contact $downline)
    {
        $this->downline = $downline;
    }

    function params(Contact $notifiable)
    {
        $alert = strtoupper(optional($this->downline->latest_alerts()->first())->name ?? 'no alert');
        $area = optional($this->downline->areas()->first())->qn ?? 'no area';
        $handle = $this->downline->handle;
        $mobile = $this->downline->mobile;

        return [
            'handle' => $handle,
            'mobile' => $mobile,
            'alert' => $alert,
            'area' => $area,
        ];
    }
}
