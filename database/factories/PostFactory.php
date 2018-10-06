<?php

use Faker\Generator as Faker;

$factory->define(\App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->realText(),
        'user_id' => \App\User::inRandomOrder()->first()->id
    ];
});
