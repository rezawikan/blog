<?php

use App\Models\PostCategory;
use Faker\Generator as Faker;

$factory->define(PostCategory::class, function (Faker $faker) {
    return [
        'name'      => $name = $faker->sentence(3),
        'slug'      => str_slug($name),
        'order'     => null,
        'parent_id' => null
    ];
});
