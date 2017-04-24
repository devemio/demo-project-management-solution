<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Utils\Statuses;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'birth_date' => $faker->dateTimeThisCentury,
        'avatar' => $faker->imageUrl($width = 640, $height = 480, 'cats'),
    ];
});

$factory->define(App\Project::class, function (Faker\Generator $faker) {
    static $projectId;

    return [
        'name' => 'Project #' . ++$projectId,
        'description' => 'Description',
        'status' => Statuses::TO_DO,
        'deadline' => date('Y-m-d'),
    ];
});
