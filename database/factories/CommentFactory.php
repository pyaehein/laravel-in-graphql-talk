<?php

use Faker\Generator as Faker;

$factory->define(\App\Comment::class, function (Faker $faker) {
    return [
        'text' => $faker->name,
        'post_id' => \App\Post::inRandomOrder()->first()->id,
        'user_id' => \App\User::inRandomOrder()->first()->id
    ];
});
