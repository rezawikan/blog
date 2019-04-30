<?php

use App\Models\Post;
use App\Models\User;
use App\Models\PostCategory;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
      'user_id'           => factory(User::class)->create()->id,
      'post_category_id'  => factory(PostCategory::class)->create()->id,
      'title'             => $faker->sentence(2),
      'body'              => $faker->text(15),
      'slug'              => str_slug($faker->sentence(2)),
      'image'             => 'default.png',
      'summary'           => $faker->text(5),
      'live'              => true
    ];
});
