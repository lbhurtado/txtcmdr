<?php

namespace App\Missive\Domain\Events;

use BenSampo\Enum\Enum;

final class SMSEvents extends Enum
{
	const CREATED = 'sms.created';
}
