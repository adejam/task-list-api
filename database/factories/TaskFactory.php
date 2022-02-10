<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'label' => $faker->name,
        'sort_order' => Task::orderBy('id', 'desc')->first()->id + 1,
        'completed_at' => now(),
    ];
});
