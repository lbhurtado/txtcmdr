<?php

use Faker\Generator as Faker;
use Faker\Factory as FakerFactory;

$factory->define(App\Missive\Domain\Models\Contact::class, function (Faker $faker) {
    $faker = FakerFactory::create('en_PH');
    return [
        'mobile' => $faker->mobileNumber,
        'handle' => $faker->name,
    ];
});
