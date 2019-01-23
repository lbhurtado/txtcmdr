<?php

use Faker\Generator as Faker;

$factory->define(App\Campaign\Domain\Models\Area::class, function (Faker $faker) {
    return [
        'name' => $faker->country,
    ];
});
