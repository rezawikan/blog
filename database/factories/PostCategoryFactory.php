<?php

namespace Database\Factories;

use App\Models\PostCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'     => $name = $this->faker->name(),
            'slug'      => Str::slug($name),
            'order'     => null,
            'parent_id' => null
        ];
    }
}
