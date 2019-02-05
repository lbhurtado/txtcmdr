<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderReportUplineUpdated extends BaseNotification
{
    protected $template = "txtcmdr.upline.report";

    protected $downline;

    protected $message;

    public function __construct(Contact $downline, $message)
    {
        $this->downline = $downline;
        $this->message = $message;
    }

    function params(Contact $notifiable)
    {
        return [
            'message' => $this->message,
            'downline' => $this->downline->handle,
        ];
    }
}
