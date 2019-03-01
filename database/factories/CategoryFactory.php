<?php

use Faker\Generator as Faker;

$factory->define(App\Campaign\Domain\Models\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
