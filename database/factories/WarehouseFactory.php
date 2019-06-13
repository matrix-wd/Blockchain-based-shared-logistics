<?php

use Faker\Generator as Faker;

$factory->define(\App\Warehouse::class, function (Faker $faker) {
    $rand = rand(1, 2);
    if($rand == 1) {
        $category = '公司';
        $company = $faker->company;
    } else {
        $category = '个人';
        $company = '';
    }
    return [
        'userId' => $faker->numberBetween(1, 100),
        'title' => '',
        'province' => '',
        'city' => '',
        'country' => '',
        'address' => '',
        'price' => $faker->numberBetween(5, 150),
        'category' => $category,
        'company' => $company,
        'description' => '',
        'length' => $faker->numberBetween(3, 20),
        'width' => $faker->numberBetween(3, 20),
        'height' => $faker->numberBetween(3, 20)
    ];
});
