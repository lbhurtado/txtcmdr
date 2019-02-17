<?php

namespace App\Charging\Domain\Classes\Availments;

use App\Charging\Domain\Classes\Availment;
use App\Charging\Domain\Classes\AirtimeKey;

class AvailOutgoingSMS extends Availment
{
    public function key()
    {
        return AirtimeKey::OUTGOING_SMS;
    }
}
