<?php
$faker = Faker\Factory::create();
return [
    'user1' => [
        'phone_short' => '9221301879',
        'phone' => '79221301879',
        'email' => 'v@v.com',
        'balance' => 0,
        'password_hash' => '$2y$13$Jpkp5Aibej7Luvys6im9CO3WpYeWRkBpJ4VW5xlFUu3.FiF6K/Skm',
        'status' => 10,
        'country_id' => 182,
        'auth_key' => 'tUu1qHcde0diwUol3xeI-18MuHkkprQI',
        'secret_key' => 'RkD_Jw0_8HEedzLk7MM-ZKEFfYR7VbMr_1392559490',
        'created_at' => '1392559490',
        'updated_at' => '1392559490',
    ],
    'user2' => [
        'phone_short' => '345345345',
        'phone' => '355345345345',
        'email' => $faker->email,
        'balance' => 0,
        // password_0
        'password_hash' => '$2y$13$Jpkp5Aibej7Luvys6im9CO3WpYeWRkBpJ4VW5xlFUu3.FiF6K/Skm',
        'status' => 1,
        'country_id' => 3,
        'auth_key' => 'tUu1qHcde0diwUol3xeI-18MuHkkprQI',
        'secret_key' => 'RkD_Jw0_8HEedzLk7MM-ZKEFfYR7VbMr_1392559490',
        'created_at' => '1392559490',
        'updated_at' => '1392559490',
    ],
    'user3' => [
        'phone_short' => '3333333333',
        'phone' => '393333333333',
        'email' => $faker->email,
        'balance' => 0,
        // password_0
        'password_hash' => '$2y$13$Jpkp5Aibej7Luvys6im9CO3WpYeWRkBpJ4VW5xlFUu3.FiF6K/Skm',
        'status' => 0,
        'country_id' => 109,
        'auth_key' => 'tUu1qHcde0diwUol3xeI-18MuHkkprQI',
        'secret_key' => 'RkD_Jw0_8HEedzLk7MM-ZKEFfYR7VbMr_1392559490',
        'created_at' => '1392559490',
        'updated_at' => '1392559490',
    ],
];
