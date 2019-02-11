<?php

namespace App\Campaign\Domain\Events;

use Opis\Events\Event;
use App\Campaign\Domain\Models\Checkin;

class CheckinEvent extends Event
{
    protected $checkin;

    public function setCheckin(Checkin $checkin)
    {
        $this->checkin = $checkin;

        return $this;
    }

    public function getCheckin()
    {
        return $this->checkin;
    }
}