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

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_force_delete_a_comment()
    {

        $permission = factory(Permission::class)->create(['name' => 'delete comment']);
        $permission2 = factory(Permission::class)->create(['name' => 'force delete comment']);
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $user->givePermissionTo([$permission->name, $permission2->name ]);

        $comment = factory(Comment::class)->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);

        $post->comments()->save($comment);

        Passport::actingAs($user);

        $response = $this->json('DELETE', "/api/comments/{$comment->id}");
        $response2 = $this->json('DELETE', "/api/comments/{$comment->id}");

        $response->assertStatus(200);
        $response2->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_restore_a_comment()
    {
        $permission   = factory(Permission::class)->create(['name' => 'create comment']);
        $permission2  = factory(Permission::class)->create(['name' => 'restore comment']);
        $permission3  = factory(Permission::class)->create(['name' => 'delete comment']);
        $user         = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $user->givePermissionTo([$permission->name,$permission2->name, $permission3->name]);

        Passport::actingAs($user);

        $comment = factory(Comment::class)->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);

        $post->comments()->save($comment);

        $delete  = $this->json('DELETE', "/api/comments/{$comment->id}");
        $restore = $this->json('PUT', "/api/comments-restore/{$comment->id}");

        $delete->assertStatus(200);
        $restore->assertStatus(200);
    }
}
