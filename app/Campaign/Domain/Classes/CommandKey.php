<?php

namespace App\Campaign\Domain\Classes;

use BenSampo\Enum\Enum;

final class CommandKey extends Enum
{
    const       TAG = 'Tag';
    const      AREA = 'Area';
    const      SEND = 'Message';
    const     GROUP = 'Group';
    const     OPTIN = 'Opt-in';
     const   REPORT = 'Report';
    const  ANNOUNCE = 'Announce';
    const  REGISTER = 'Registration';
    const BROADCAST = 'Broadcast';
}
