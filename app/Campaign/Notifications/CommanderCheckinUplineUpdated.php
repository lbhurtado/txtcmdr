<?php

namespace App\Campaign\Notifications;

use App\Missive\Domain\Models\Contact;

class CommanderCheckinUplineUpdated extends BaseNotification
{
    protected $downline;

    protected $template = "txtcmdr.upline.checkin";

    public $queue = 'checkin';

    public function __construct(Contact $downline)
    {
        $this->downline = $downline;
    }

    function params(Contact $notifiable)
    {
        $handle = $this->downline->handle;
        $mobile = $this->downline->mobile;
        $location = 'location not yet available';
        $id = 0;

        optional($this->downline->latestCheckin()->first(), function ($checkin) use (&$location, &$id) {
            $location = $checkin->mapUrl;
            $id = $checkin->id;
        });

        return [
            'handle' => $handle,
            'mobile' => $mobile,
            'id' => $id,
            'location' => $location,
        ];
    }
}
