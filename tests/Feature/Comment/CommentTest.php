<?php

namespace Tests\Feature\Comment;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\PostCategory;
use Laravel\Passport\Passport;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_make_a_comment()
    {
        $permission   = factory(Permission::class)->create(['name' => 'create comment']);
        $post         = factory(Post::class)->create();
        $user         = factory(User::class)->create();

        $user->givePermissionTo('create comment');
        Passport::actingAs($user);

        $response = $this->post('/api/comments', [
          'body' => 'Testing',
          'approved' => true,
          'parent_id' => null,
          'user_id' => $user->id,
          'post_id' => $post->id
        ]);

        $response->assertStatus(201);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_not_make_a_comment()
    {
        $permission   = factory(Permission::class)->create(['name' => 'create comment']);
        $post         = factory(Post::class)->create();
        $user         = factory(User::class)->create();

        $user->givePermissionTo('create');
        Passport::actingAs($user);

        $response = $this->post('/api/comments', [
          'body' => 'Testing',
          'approved' => true,
          'parent_id' => null,
          'user_id' => $user->id,
          'post_id' => $post->id
        ]);

        $response->assertStatus(403);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_access_comments()
    {
        $user  = factory(User::class)->create();
        $post  = factory(Post::class)->create();
        $comment = factory(Comment::class)->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);
        $post->comments()->save($comment);

        Passport::actingAs($user);

        $response = $this->get('/api/comments');

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_access_comment_detail()
    {
        $user  = factory(User::class)->create();
        $post  = factory(Post::class)->create();
        $comment = factory(Comment::class)->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);
        $post->comments()->save($comment);

        Passport::actingAs($user);

        $response = $this->get("/api/comments/{$comment->id}");

        $response->assertStatus(200);
    }



    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_update_a_comment()
    {
        $permission   = factory(Permission::class)->create(['name' => 'update comment']);
        $user  = factory(User::class)->create();
        $post  = factory(Post::class)->create();
        $comment = factory(Comment::class)->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);

        $post->comments()->save($comment);

        $user->givePermissionTo('update comment');

        Passport::actingAs($user);

        $response = $this->actingAs($user)->json('PATCH', "/api/comments/{$comment->id}", [
          'body' => 'testing1s',
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_delete_a_comment()
    {
        $permission = factory(Permission::class)->create(['name' => 'delete comment']);
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $user->givePermissionTo('delete comment');

        $comment = factory(Comment::class)->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);

        $post->comments()->save($comment);

        Passport::actingAs($user);

        $response = $this->json('DELETE', "/api/comments/{$comment->id}");

        $response->assertStatus(200);
    }
    //
    // /**
    //  * A basic unit test example.
    //  *
    //  * @return void
    //  */
    // public function test_user_can_force_delete_a_post()
    // {
    //     $permission  = factory(Permission::class)->create(['name' => 'delete post']);
    //     $permission2 = factory(Permission::class)->create(['name' => 'force delete post']);
    //     $user = factory(User::class)->create();
    //
    //     $user->givePermissionTo('delete post');
    //     $user->givePermissionTo('force delete post');
    //
    //     $post = factory(Post::class)->create();
    //
    //     Passport::actingAs($user);
    //
    //     $response  = $this->json('DELETE', "/api/posts/{$post->id}");
    //     $response2 = $this->json('DELETE', "/api/posts/{$post->id}");
    //
    //     $response->assertStatus(200);
    //     $response2->assertStatus(200);
    // }
    //
    // /**
    //  * A basic unit test example.
    //  *
    //  * @return void
    //  */
    // public function test_user_can_restore_a_post()
    // {
    //     $permission   = factory(Permission::class)->create(['name' => 'create post']);
    //     $permission2  = factory(Permission::class)->create(['name' => 'restore post']);
    //     $permission3  = factory(Permission::class)->create(['name' => 'delete post']);
    //     $postCategory = factory(PostCategory::class)->create();
    //     $user         = factory(User::class)->create();
    //
    //     $user->givePermissionTo([$permission->name,$permission2->name, $permission3->name]);
    //
    //     Passport::actingAs($user);
    //
    //     $store = $this->post('/api/posts', [
    //       'title'            => 'Test',
    //       'body'             => 'Lorem ipsum',
    //       'user_id'          => $user->id,
    //       'post_category_id' => $postCategory->id,
    //       'slug'             => str_slug('Lorem ipsum'),
    //       'image'            => 'default.png',
    //       'summary'          => 'Lorem ipsum',
    //       'live'             => true
    //     ]);
    //
    //     $post = Post::first();
    //
    //     $delete  = $this->json('DELETE', "/api/posts/{$post->id}");
    //
    //     $restore = $this->json('PUT', "/api/posts-restore/{$post->id}");
    //
    //     $store->assertStatus(201);
    //     $delete->assertStatus(200);
    //     $restore->assertStatus(200);
    // }
}
