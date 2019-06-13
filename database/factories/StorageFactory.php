<?php

use Faker\Generator as Faker;

$factory->define(\App\Storage::class, function (Faker $faker) {
    return [
        'warehouseId' => $faker->numberBetween(1, 20),
        'usedArea' => $faker->numberBetween(0, 200),
        'price' => $faker->numberBetween(0, 50),
        'startTime' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years', $timezone = null),
        'endTime' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        'description' => $faker->text,
    ];
});
