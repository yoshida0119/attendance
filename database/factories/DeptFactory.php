<?php

use App\Dept;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Dept::class, function (Faker $faker) {
    return [
        'dept_name' => $faker->unique()->safeEmail,
        'del_flg' => null,
    ];
});
