<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    $isbnArr = array("0005534186", "0978110196", "0978108248", "0978194527", "0978194004",
                "0978194985", "0978171349", "0978039912", "0978031644", "0978168968",
                "0978179633", "0978006232", "0978195248", "0978125029", "0978078691",
                "0978152476", "0978153871", "0978125010", "0593139135", "0441013597");

    return [
        'title' => $faker->sentence($faker->numberBetween(3,10)),
        'isbn' => $faker->unique()->randomElement($isbnArr),
        'publication_date' => $faker->dateTimeBetween('-30 years', 'now'),
        'status' => 'AVAILABLE'
    ];
});
