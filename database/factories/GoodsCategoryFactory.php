<?php

use Faker\Generator as Faker;

$factory->define(\App\Http\Models\GoodsCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->title,
        'parent_id' => rand(0,3),
    ];
});
