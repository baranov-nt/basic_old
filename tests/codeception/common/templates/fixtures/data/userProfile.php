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
        'images_num' => 5,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => '',
        'the_second_phone' => $faker->phoneNumber,
        'the_third_phone' => $faker->phoneNumber,
    ],
    'user2' => [
        'images_num' => 5,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => '',
        'the_second_phone' => $faker->phoneNumber,
        'the_third_phone' => $faker->phoneNumber,
    ],
    'user3' => [
        'images_num' => 5,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => '',
        'the_second_phone' => $faker->phoneNumber,
        'the_third_phone' => $faker->phoneNumber,
    ],
];