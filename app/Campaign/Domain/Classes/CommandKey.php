<?php

namespace App\Campaign\Domain\Classes;

use BenSampo\Enum\Enum;

final class CommandKey extends Enum
{
    const       TAG = 'Tag';
    const      AREA = 'Area';
    const      SEND = 'Message';
    const      INFO = 'Information';
    const      TEST = 'Test';
    const     GROUP = 'Group';
    const     ALERT = 'Alert';
    const     OPTIN = 'Opt-in';
    const    REPORT = 'Report';
    const    STATUS = 'Status';
    const  ANNOUNCE = 'Announce';
    const  REGISTER = 'Registration';
    const BROADCAST = 'Broadcast';
    const ATTRIBUTE = 'Attribute';
}
