<?php

namespace App\Charging\Domain\Formatters;

class CreditsFormatter
{
	protected $credits;

	public function __construct($credits)
	{
		$this->credits = $credits;
	}

	public function value()
	{
		return $this->credits;
	}

	public function number()
	{
		return number_format($this->value());
	}

	public function shorthand()
	{
		$credits = $this->value();

		if ($credits == 0) {

			return 0;
		} 

		switch ($credits) {
			case $credits < 1000:
				return number_format($credits);
				break;
			case $credits < 1000000:
				return sprintf(
					'%sk',
					(float) number_format($credits/1000, 1)
				); 
				break;
			case $credits < 1000000000:
				return sprintf(
					'%sM',
					(float) number_format($credits/1000000, 1)
				); 
				break;
		}
	}
}