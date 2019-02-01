<?php

namespace App\Campaign\Domain\Classes;

use BenSampo\Enum\Enum;

final class InfoKey extends Enum
{
    const         TAG = 'Tag Description'; //change the description part
    const        AREA = 'Area Description';
    const       GROUP = 'Group Description';
    const       ALERT = 'Alert Description';
    const      SIGNAL = 'Signal Description';
    const      STATUS = 'Status Description';
    const      UPLINE = 'Upline Description';
    const    DOWNLINE = 'Downline Description';
    const   ATTRIBUTE = 'Attribute Description';
    const DESCENDANTS = 'Descendants Description';
}
