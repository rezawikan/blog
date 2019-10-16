<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $post = factory(Post::class)->create();
    $class = new \ReflectionClass($post);
    return [
        'user_id'  => factory(User::class)->create()->id,
        'body'     => $faker->sentence(10),
        'approved' => true,
        'commentable_id' => $post->id,
        'commentable_type' => $class->getName()
    ];
});
