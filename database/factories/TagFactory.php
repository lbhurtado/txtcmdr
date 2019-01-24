<?php

use Faker\Generator as Faker;
use App\Missive\Domain\Models\Contact;

$factory->define(App\Campaign\Domain\Models\Tag::class, function (Faker $faker) {
    return [
        'code' => $faker->word,
        'tagger_id' => factory(Contact::class)->create()->id,
        'tagger_type' => Contact::class
    ];
});