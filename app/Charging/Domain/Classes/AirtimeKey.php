<?php

namespace App\Charging\Domain\Classes;

use BenSampo\Enum\Enum;

final class AirtimeKey extends Enum
{
    const INCOMING_SMS  = 'incoming-sms';
    const OUTGOING_SMS  = 'outgoing-sms';
    const LBS           = 'lbs';
    const LOAD10        = 'load-10';
    const LOAD25        = 'load-25';
}
