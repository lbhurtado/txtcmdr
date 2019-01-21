<?php

namespace App\Charging\Domain\Classes\Availments;

use App\Airtime\Domain\Classes\Availment;
use App\Charging\Domain\Classes\AirtimeKey;

class AvailSMS extends Availment
{
	public function key()
	{
		return AirtimeKey::SMS;
	}
}