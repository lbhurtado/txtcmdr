<?php

use App\Charging\Domain\Classes\AirtimeKey;

return [
	'airtime' => [
		'availments' => [
			AirtimeKey::SMS => App\Charging\Domain\Classes\Availments\AvailSMS::class,
			AirtimeKey::LOAD10 => App\Charging\Domain\Classes\Availments\AvailLoad10::class,
		],
	],
];