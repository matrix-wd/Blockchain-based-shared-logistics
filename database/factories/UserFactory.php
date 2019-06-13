<?php

use Faker\Generator as Faker;


$factory->define(\App\User::class, function (Faker $faker) {
    $rand = rand(1, 2);
    if($rand == 1) {
        $gender = '男';
    } else {
        $gender = '女';
    }
    return [
        'username' => $faker->name,
        'password' => '123456',
        'gender' => $gender,
        'province' => '',
        'city' => '',
        'country' => '',
        'address' => '',
        'idCard' => '',
        'telephone' => $faker->phoneNumber,
        //'type' => $faker->numberBetween(1, 7),
        'lastLoginIp' => $faker->ipv4,
        'lastLoginTime' => $faker->dateTime()
    ];
});
