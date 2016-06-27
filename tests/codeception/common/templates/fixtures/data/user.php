<?php
$faker = Faker\Factory::create();
return [
    'user1' => [
        'phone' => '79221301879',
        'email' => 'v@v.com',
        'balance' => 0,
        // password_0
        'password_hash' => '$2y$13$Jpkp5Aibej7Luvys6im9CO3WpYeWRkBpJ4VW5xlFUu3.FiF6K/Skm',
        'status' => 10,
        'country_id' => 182,
        'auth_key' => 'tUu1qHcde0diwUol3xeI-18MuHkkprQI',
        'secret_key' => 'RkD_Jw0_8HEedzLk7MM-ZKEFfYR7VbMr_1392559490',
        'created_at' => '1392559490',
        'updated_at' => '1392559490',
    ],
    'user2' => [
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'balance' => 0,
        // password_0
        'password_hash' => '$2y$13$Jpkp5Aibej7Luvys6im9CO3WpYeWRkBpJ4VW5xlFUu3.FiF6K/Skm',
        'status' => 0,
        'country_id' => 170,
        'auth_key' => 'tUu1qHcde0diwUol3xeI-18MuHkkprQI',
        'secret_key' => 'RkD_Jw0_8HEedzLk7MM-ZKEFfYR7VbMr_1392559490',
        'created_at' => '1392559490',
        'updated_at' => '1392559490',
    ],
    'user3' => [
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'balance' => 0,
        // password_0
        'password_hash' => '$2y$13$Jpkp5Aibej7Luvys6im9CO3WpYeWRkBpJ4VW5xlFUu3.FiF6K/Skm',
        'status' => 0,
        'country_id' => 14,
        'auth_key' => 'tUu1qHcde0diwUol3xeI-18MuHkkprQI',
        'secret_key' => 'RkD_Jw0_8HEedzLk7MM-ZKEFfYR7VbMr_1392559490',
        'created_at' => '1392559490',
        'updated_at' => '1392559490',
    ],
];
