<?php

namespace Tests\Unit\Models\PostCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PostCategory;

class PostCategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_has_many_children()
    {
        $category = factory(PostCategory::class)->create();

        $category->children()->save(
        factory(PostCategory::class)->create(),
        factory(PostCategory::class)->create()
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
        $category = factory(PostCategory::class)->create();

        $category->children()->save(
          $child = factory(PostCategory::class)->create()
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
        $category = factory(PostCategory::class)->create([
        'order' => 2
      ]);

        $otherCategory = factory(PostCategory::class)->create([
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
        $category = factory(PostCategory::class)->create();

        $category->children()->save(
          $child = factory(PostCategory::class)->create()
        );

        $child->children()->save(
          $child1 = factory(PostCategory::class)->create()
        );

        $this->assertInstanceOf(PostCategory::class, $category->childrenRecursive()->first());
    }
}
