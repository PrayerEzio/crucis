<?php

use Faker\Generator as Faker;

$factory->define(\App\Http\Models\Product::class, function (Faker $faker) {
    return [
        'goods_id' => rand(1,50),
        'stock' => rand(0,10),
        'price' => $faker->randomFloat(2,10,200),
        'status' => rand(0,1),
    ];
});
