<?php

namespace Tests\Unit\Models\Tag;

use App\Models\Tag;
use App\Models\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_tag_can_attach_some_posts()
    {
        $post1  = factory(Post::class)->create();
        $post2  = factory(Post::class)->create();
        $tag1   = factory(Tag::class)->create();

        $tag1->posts()->saveMany([$post1, $post2]);

        $this->assertCount(2, $tag1->posts);
    }
}
