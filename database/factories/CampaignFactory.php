<?php

use Faker\Generator as Faker;

$factory->define(App\Campaign\Domain\Models\Campaign::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'message' => $faker->sentence,
    ];
});