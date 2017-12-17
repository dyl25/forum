<?php

use Faker\Generator as Faker;

$factory->define(App\Thread::class, function (Faker $faker) {
    return [
        //on crée un user et on récupère son id pour l'associer à un thread
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
