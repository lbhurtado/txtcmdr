<?php

use App\Charging\Domain\Classes\AirtimeKey;

return [
	'airtime' => [
		'availments' => [
			AirtimeKey::SMS 	 => App\Charging\Domain\Classes\Availments\AvailSMS::class,
			AirtimeKey::LOAD10   => App\Charging\Domain\Classes\Availments\AvailLoad10::class,
			AirtimeKey::LOAD20   => App\Charging\Domain\Classes\Availments\AvailLoad20::class,
			AirtimeKey::LOAD50   => App\Charging\Domain\Classes\Availments\AvailLoad50::class,
			AirtimeKey::LOAD100  => App\Charging\Domain\Classes\Availments\AvailLoad100::class,
			AirtimeKey::LOAD500  => App\Charging\Domain\Classes\Availments\AvailLoad500::class,
			AirtimeKey::LOAD1000 => App\Charging\Domain\Classes\Availments\AvailLoad1000::class,
		],
	],
];