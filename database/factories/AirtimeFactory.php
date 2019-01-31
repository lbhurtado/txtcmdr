<?php

use Faker\Generator as Faker;
use App\Charging\Domain\Models\Airtime;
use App\Charging\Domain\Classes\AirtimeKey;

$factory->define(Airtime::class, function (Faker $faker) {
    return [
        'key' => AirtimeKey::getRandomValue(),
        'credits' => rand(1,100),
    ];
});
