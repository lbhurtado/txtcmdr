<?php

namespace App\Campaign\Domain\Classes;

use BenSampo\Enum\Enum;

final class CommandKey extends Enum
{
    const       PIN = 'pin';
    const       TAG = 'tag';
    const      AREA = 'area';
    const     GROUP = 'group';
    const   COMMAND = 'command';
    const   MESSAGE = 'message';
    const  CAMPAIGN = 'campaign';
}
