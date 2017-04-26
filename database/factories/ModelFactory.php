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
    static $number = 1;

    return [
        'name' => $faker->name,
        'email' => 'test' . $number++ . '@example.dev', // $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'birth_date' => $faker->dateTimeThisCentury,
        'avatar' => $faker->imageUrl($width = 640, $height = 480, 'cats'),
    ];
});

$factory->define(App\Project::class, function (Faker\Generator $faker) {
    static $projectID = 1;

    return [
        'user_id' => App\User::inRandomOrder()->get()->first()->getID(),
        'name' => 'Project #' . $projectID++,
        'description' => 'Project description',
        'status' => Statuses::TO_DO,
        'deadline' => $faker->dateTimeThisYear,
    ];
});

$factory->define(App\Task::class, function (Faker\Generator $faker) {
    static $taskID = 1;

    return [
        'user_id' => App\User::inRandomOrder()->get()->first()->getID(),
        'assigned_to' => App\User::inRandomOrder()->get()->first()->getID(),
        'name' => 'Task #' . $taskID++,
        'description' => 'Task description',
        'status' => Statuses::TO_DO,
        'deadline' => $faker->dateTimeThisYear,
    ];
});
