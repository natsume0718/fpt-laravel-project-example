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
        'name' => $faker->text(50),
        'content' => $faker->text(),
        'price' => $faker->randomNumber(6),
        'discount' => 0,
        'feature_image' => '/src/images/default-feature-image.png',
        'status' => 1,
        'user_id' => 1,
    ];
});
