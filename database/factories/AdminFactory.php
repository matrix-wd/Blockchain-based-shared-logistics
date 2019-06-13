<?php

use Faker\Generator as Faker;

$factory->define(\App\Admin::class, function (Faker $faker) {
    return [
        'telephone' => $faker->phoneNumber,
        'password' => '123456',
        'lastLoginIp' => $faker->ipv4,
        'lastLoginTime' => $faker->dateTime()
    ];
});
