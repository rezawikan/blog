<?php

namespace Tests\Unit\Models\PostCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PostCategory;
use App\Models\Post;

class PostCategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_has_many_children()
    {
        $category = PostCategory::factory()->create();

        $category->children()->save(
            PostCategory::factory()->create(),
            PostCategory::factory()->create()
        );

        $this->assertInstanceOf(PostCategory::class, $category->children->first());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_children_only_has_one_parent()
    {
        $category = PostCategory::factory()->create();

        $category->children()->save(
            $child = PostCategory::factory()->create()
        );

        $this->assertEquals(1, $child->parents()->count());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_is_orderable_by_a_numbered_order()
    {
        $category = PostCategory::factory()->create([
        'order' => 2
      ]);

        $otherCategory = PostCategory::factory()->create([
        'order' => 1
      ]);

        $this->assertEquals($otherCategory->name, PostCategory::ordered()->first()->name);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_has_many_children_recursive()
    {
        $category = PostCategory::factory()->create();

        $category->children()->save(
            $child = PostCategory::factory()->create()
        );

        $child->children()->save(
            $child1 = PostCategory::factory()->create()
        );

        $this->assertInstanceOf(PostCategory::class, $category->childrenRecursive()->first());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_post_category_has_many_post()
    {
        $category = PostCategory::factory()->create();
        Post::factory()->create([
          'post_category_id' => $category->id
        ]);
        Post::factory()->create([
          'post_category_id' => $category->id
        ]);

        $this->assertCount(2, $category->posts);
    }
}
