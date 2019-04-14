<?php

use Faker\Generator as Faker;

$factory->define(App\Campaign\Domain\Models\Stub::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->regexify('[A-Z][A-Z][A-Z][A-Z]'),
    ];
});
