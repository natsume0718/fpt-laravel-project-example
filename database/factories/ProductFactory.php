<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Product;
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

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->text(),
        'content' => $faker->text(),
        'price' => $faker->unique()->randomNumber(1),
        'feature_image' => $faker->imageUrl(),
        'status' => 1,
        'user_id' => 1,
    ];
});
