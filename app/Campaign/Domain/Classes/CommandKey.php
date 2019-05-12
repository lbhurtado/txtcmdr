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
    const      HELP = 'Help';
    const     GROUP = 'Group';
    const     ALERT = 'Alert';
    const     OPTIN = 'Opt-in';
    const    REPORT = 'Report';
    const    STATUS = 'Status';
    const   CHECKIN = 'Check-in';
    const  ANNOUNCE = 'Announce';
    const  REGISTER = 'Registration';
    const BROADCAST = 'Broadcast';
    const ATTRIBUTE = 'Attribute';
    const   CONFIRM = 'Confirm';
    const      POLL = 'Poll';
}
