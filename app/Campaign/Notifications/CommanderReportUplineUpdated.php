<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\SMS;
use App\Missive\Domain\Models\Contact;

class CommanderReportUplineUpdated extends BaseNotification
{
    protected $template = "txtcmdr.upline.report";

    protected $downline;

    protected $sms;

    protected $message;

    public function __construct(Contact $downline, SMS $sms, $message)
    {
        $this->downline = $downline;
        $this->sms = $sms;
        $this->message = $message;
    }

    function params(Contact $notifiable)
    {
        return [
            'message' => $this->message,
            'downline' => optional($this->downline)->handle ?: $this->sms->from,
        ];
    }
}
