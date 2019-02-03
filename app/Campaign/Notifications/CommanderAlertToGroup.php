<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderAlertToGroup extends BaseNotification
{
    protected $whistleBlower;

    protected $template = "txtcmdr.group.alert";

    public function __construct(Contact $whistleBlower)
    {
        $this->whistleBlower = $whistleBlower;
    }

    function params(Contact $notifiable)
    {
        $alert = strtoupper(optional($this->whistleBlower->latest_alerts()->first())->name ?? 'no alert');
        $area = optional($this->whistleBlower->areas()->first())->qn ?? 'no area';
        $handle = $this->whistleBlower->handle;
        $mobile = $this->whistleBlower->mobile;

        return [
            'handle' => $handle,
            'mobile' => $mobile,
            'alert' => $alert,
            'area' => $area,
        ];
    }
}
