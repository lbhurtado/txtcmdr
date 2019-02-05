<?php

namespace App\Campaign\Notifications;

use App\Campaign\Domain\Models\Area;
use App\Missive\Domain\Models\Contact;

class CommanderSendToArea extends BaseNotification
{
    protected $template = "txtcmdr.commander.send.area";

    protected $area;

    protected $message;

    public function __construct(Area $area, $message)
    {
        $this->area = $area;
        $this->message = $message;
    }

    function params(Contact $notifiable)
    {
        return [
            'area' => $this->area->qn,
            'message' => $this->message,
        ];
    }
}

