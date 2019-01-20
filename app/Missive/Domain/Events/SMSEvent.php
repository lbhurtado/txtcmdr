<?php

namespace App\Missive\Domain\Events;

use Opis\Events\Event;
use App\Missive\Domain\Models\SMS;

class SMSEvent extends Event
{
    protected $sms;

    public function setSMS(SMS $sms)
    {
        $this->sms = $sms;
    }
    
    public function getSMS()
    {
        return $this->sms;
    }
}
