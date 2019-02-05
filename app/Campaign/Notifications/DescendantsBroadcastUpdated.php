<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class DescendantsBroadcastUpdated extends BaseNotification
{
    protected $template = "txtcmdr.descendants.broadcast";

    protected $origin;

    protected $message;

    public function __construct(Contact $origin, $message)
    {
        $this->origin = $origin;
        $this->message = $message;
    }

    function params(Contact $notifiable)
    {
        return [
            'message' => $this->message,
            'origin' => $this->origin->handle,
        ];
    }
}
