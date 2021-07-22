<?php

namespace Tests\Unit\Models\Post;

use App\Models\User;
use App\Models\Tag;
use App\Models\Post;
use App\Models\PostCategory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_post_has_one_category()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(PostCategory::class, $post->post_category);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_post_can_update_a_category()
    {
        $category = PostCategory::factory()->create();
        $post     = Post::factory()->create();

        $post->update(['post_category_id' => $category->id]);

        $this->assertEquals($category->name, $post->post_category->name);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_post_can_add_some_tags()
    {
        $tag1     = Tag::factory()->create();
        $tag2     = Tag::factory()->create();
        $post     = Post::factory()->create();
        $post->tags()->saveMany([$tag1, $tag2]);

        $this->assertCount(2, $post->tags);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_post_has_one_user()
    {
        $post = Post::factory()->create();
        $this->assertInstanceOf(User::class, $post->user);
    }
}
