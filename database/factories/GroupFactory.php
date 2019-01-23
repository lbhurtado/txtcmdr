<?php

use Faker\Generator as Faker;

$factory->define(App\Campaign\Domain\Models\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
