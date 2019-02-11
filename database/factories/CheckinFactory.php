<?php

use Faker\Generator as Faker;
use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Models\Checkin;

$factory->define(Checkin::class, function (Faker $faker) {
    return [
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
        'contact_id' => factory(Contact::class)->create()->id,
    ];
});
