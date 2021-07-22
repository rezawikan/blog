<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\PostCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'user_id'           => User::factory()->create()->id,
          'post_category_id'  => PostCategory::factory()->create()->id,
          'title'             => $title = $this->faker->sentence(2),
          'body'              => $this->faker->text(15),
          'slug'              => Str::slug($title),
          'image'             => 'default.png',
          'summary'           => $this->faker->text(5),
          'live'              => true
        ];
    }
}
