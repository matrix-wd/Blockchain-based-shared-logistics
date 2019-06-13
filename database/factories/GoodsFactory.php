<?php

use Faker\Generator as Faker;

$factory->define(\App\Goods::class, function (Faker $faker) {
    return [
        'userId' => $faker->numberBetween(1, 100),
        'province' => '四川省',
        'city' => $faker->city,
        'region' => $faker->streetAddress,
        'address' => $faker->address,
        'company' => $faker->company,
        'area' => $faker->numberBetween(0, 200),
        'price' => $faker->numberBetween(0, 500),
        'weight' => $faker->numberBetween(0, 10),
        'goodsImage' => './img/goods/one.jpg',
        'checkedTime' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null),
        'startTime' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years', $timezone = null),
        'endTime' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        'description' => $faker->text,
    ];
});
