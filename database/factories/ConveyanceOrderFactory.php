<?php

use Faker\Generator as Faker;

$factory->define(\App\ConveyanceOrder::class, function (Faker $faker) {
    $price = $faker->numberBetween(1, 10);
    $area = $faker->numberBetween(1, 10);
    $distance = $faker->numberBetween(10, 300);
    $amount = $price * $area * $distance;
    return [
        'userId' => $faker->numberBetween(1, 60),
        'resourceId' => $faker->numberBetween(1, 30),
        'price' => $price,
        'province' => '',
        'city' => '',
        'country' => '',
        'address' => '',
        'area' => $area,
        'distance' => $distance,
        'content' => '',
        'status' => $faker->numberBetween(0, 3),
        'replyContent' => '',
        'amount' => $amount,
        'score' => 0
    ];
});
