<?php

use Faker\Generator as Faker;

$factory->define(\App\Order::class, function (Faker $faker) {
    $number = rand(1, 2);
    if($number == 1) {
        $type = 'warehouse';
    } else {
        $type = 'conveyance';
    }
    $price = $faker->numberBetween(1, 10);
    $area = $faker->numberBetween(1, 10);
    return [
        'userId' => $faker->numberBetween(1, 100),
        'resourceId' => $faker->numberBetween(1, 25),
        'price' => $price,
        'startDate' => $faker->dateTimeBetween($startDate = '-10 months', $endDate = 'now', $timezone = null),
        'endDate' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+5 months', $timezone = null),
        'area' => $area,
        'rate' => $faker->numberBetween(1, 5),
        'amount' => $price * $area,
        'type' => $type
    ];
});
