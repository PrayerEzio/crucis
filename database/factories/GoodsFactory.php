<?php

use Faker\Generator as Faker;

$factory->define(\App\Http\Models\Goods::class, function (Faker $faker) {
    return [
        'category_id' => rand(1,10),
        'name' => $faker->title,
        'sub_title' => $faker->text(),
        'picture' => $faker->imageUrl(),
        'detail' => $faker->text()
    ];
});
