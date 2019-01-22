<?php

namespace App\Charging\Domain\Classes;

use App\Charging\Domain\Models\Airtime;	
use App\Charging\Domain\Repositories\AirtimeRepository;

abstract class Availment
{
	protected $airtimes;

	abstract public function key();

	public function __construct(AirtimeRepository $airtimes)
	{
		$this->airtimes = $airtimes;
	}

	public function getAirtime():Airtime
	{
		return $this->airtimes->findByField('key', $this->key())->first();
	}
}