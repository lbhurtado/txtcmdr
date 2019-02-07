<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class DownlineAnnouncementUpdated extends BaseNotification
{
    protected $template = "txtcmdr.downline.announce";

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    function params(Contact $notifiable)
    {
        return [
            'message' => $this->message,
            'upline' => $notifiable->parent->handle
        ];
    }
}
