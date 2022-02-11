<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'label' => $faker->name,
        'sort_order' => 1,
        'completed_at' => now(),
    ];
});
