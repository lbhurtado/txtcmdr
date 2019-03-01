<?php

use Faker\Generator as Faker;
use App\Campaign\Domain\Models\Category;

$factory->define(App\Campaign\Domain\Models\Issue::class, function (Faker $faker) {
    $firstName = $faker->firstName;

    return [
        'code' => $firstName,
        'name' => string($firstName)->concat(' ')->concat($faker->lastName),
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        }
    ];
});
