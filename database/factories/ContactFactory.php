<?php

use Faker\Generator as Faker;

$factory->define(App\Missive\Domain\Models\Contact::class, function (Faker $faker) {
    return [
        'mobile' => $faker->phoneNumber,
        'name' => $faker->name,
    ];
});
