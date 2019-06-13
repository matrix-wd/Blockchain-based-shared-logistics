<?php

use Faker\Generator as Faker;

$factory->define(\App\Attention::class, function (Faker $faker) {
    return [
        'userId' => 100,
        'resourceId' => $faker->numberBetween(1, 100),
        'type' => 'warehouse'
    ];
});
