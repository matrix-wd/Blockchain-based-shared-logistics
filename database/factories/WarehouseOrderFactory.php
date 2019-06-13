<?php

use Faker\Generator as Faker;

$factory->define(\App\WarehouseOrder::class, function (Faker $faker) {
    $area = $faker->numberBetween(1, 10);
    $price = $faker->numberBetween(1, 10);
    return [
        'userId' => $faker->numberBetween(1, 60),
        'resourceId' => $faker->numberBetween(1, 30),
        'price' => $price,
        'startDate' => $faker->dateTimeBetween($startDate = '-10 months', $endDate = 'now', $timezone = null),
        'endDate' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+5 months', $timezone = null),
        'area' => $area,
        'content' => '棉花',
        'status' => $faker->numberBetween(0, 3),
        'replyContent' => '',
        'amount' => $area * $price,
        'score' => $faker->numberBetween(0, 5)
    ];
});
