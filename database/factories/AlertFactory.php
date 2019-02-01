<?php

use Faker\Generator as Faker;

$factory->define(App\Campaign\Domain\Models\Alert::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
