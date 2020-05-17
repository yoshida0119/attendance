<?php

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => "test@test.co.jp",
//        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' =>  Hash::make('test0001'), // password
        'remember_token' => Str::random(10),
    ];
});
