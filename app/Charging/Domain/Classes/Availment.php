<?php

namespace App\Charging\Domain\Classes;

use App\Charging\Domain\Models\Airtime;
use App\Charging\Domain\Classes\AirtimeKey;
use App\Charging\Domain\Repositories\AirtimeRepository;

abstract class Availment
{
	protected $airtimes;

	abstract public function key():AirtimeKey

	public function __construct(AirtimeRepository $airtimes)
	{
		$this->airtimes = $airtimes;
	}

	public function getAirtime(): Airtime
	{
		return $this->airtimes->byKey($this->key());
	}
}