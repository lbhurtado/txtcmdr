<?php

use Faker\Generator as Faker;

$factory->define(App\Campaign\Domain\Models\Issue::class, function (Faker $faker) {
    $firstName = $faker->firstName;

    return [
        'code' => $firstName,
        'name' => string($firstName)->concat(' ')->concat($faker->lastName),
    ];
});
