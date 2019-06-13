<?php

use Faker\Generator as Faker;

$factory->define(\App\Conveyance::class, function (Faker $faker) {
    $rand = rand(1, 2);
    if($rand == 1) {
        $category = '公司';
    } else {
        $category = '个人';
    }
    $type = ['大货车', '普通货车', '小货车', '面包车', '其他'];

    return [
        'userId' => $faker->numberBetween(1, 100),
        'province' => '',
        'city' => '',
        'country' => '',
        'address' => '',
        'category' => $category,
        'company' => '',
        'length' => $faker->numberBetween(3, 20),
        'width' => $faker->numberBetween(3, 20),
        'height' => $faker->numberBetween(2, 5),
        'price' => $faker->numberBetween(3, 20),
        'number' => $faker->numberBetween(1, 40),
        'type' => $type[rand(0,4)],
        'title' => '',
        'description' => '',
        'maxWeight' => $faker->numberBetween(20, 200)
    ];
});
