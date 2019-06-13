<?php

use Faker\Generator as Faker;

$factory->define(\App\Transport::class, function (Faker $faker) {
    return [
        'conveyanceId' => $faker->numberBetween(1, 100),
        'province' => '四川省',
        'city' => $faker->city,
        'region' => $faker->streetAddress,
        'address' => $faker->address,
        'usedArea' => $faker->numberBetween(0, 100),
        'price' => $faker->numberBetween(0, 50),
        'startTime' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years', $timezone = null),
        'endTime' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        'description' => $faker->text,
    ];
});
