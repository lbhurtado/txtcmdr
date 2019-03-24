<?php

use Faker\Generator as Faker;
use App\Missive\Domain\Models\Contact;

$factory->define(App\Campaign\Domain\Models\Tag::class, function (Faker $faker) {
    return [
        'code' => $faker->word,
        'contact_id' => factory(Contact::class)->create()->id,
//        'tagger_id' => factory(Contact::class)->create()->id,
//        'tagger_type' => Contact::class
    ];
});
