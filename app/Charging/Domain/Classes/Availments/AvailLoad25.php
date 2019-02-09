<?php

namespace App\Charging\Domain\Classes\Availments;

use App\Charging\Domain\Classes\Availment;
use App\Charging\Domain\Classes\AirtimeKey;

class AvailLoad25 extends Availment
{
    public function key()
    {
        return AirtimeKey::LOAD25;
    }
}
