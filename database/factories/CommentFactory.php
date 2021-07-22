<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $post = Post::factory()->create();
        $class = new \ReflectionClass($post);
        return [
            'user_id'  => User::factory()->create()->id,
            'body'     => $this->faker->sentence(10),
            'approved' => true,
            'commentable_id' => $post->id,
            'commentable_type' => $class->getName()
        ];
    }
}
