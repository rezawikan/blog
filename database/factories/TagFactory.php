<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
      'name'      => $name = $faker->userName,
      'slug'      => str_slug($name)
  ];
});
