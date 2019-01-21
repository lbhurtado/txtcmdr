<?php

namespace App\Charging\Domain\Classes;

use BenSampo\Enum\Enum;

final class AirtimeKey extends Enum
{
    const SMS 	   = 'sms';
    const LOAD10   = 'load-10';
    const LOAD20   = 'load-20';
    const LOAD50   = 'load-50';
    const LOAD100  = 'load-100';
    const LOAD500  = 'load-500';
    const LOAD1000 = 'load-1000';
}
