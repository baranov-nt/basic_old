<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.04.2016
 * Time: 14:36
 */
$faker = Faker\Factory::create();
return [
    'user1' => [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => '',
    ],
    'user2' => [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => '',
    ],
    'user3' => [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => '',
    ],
];