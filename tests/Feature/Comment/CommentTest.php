<?php

namespace Tests\Feature\Comment;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\PostCategory;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Str;
use Tests\TestCase;
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
        $permission   = Permission::factory()->create(['name' => 'create comment']);
        $post         = Post::factory()->create();
        $user         = User::factory()->create();

        $user->givePermissionTo('create comment');
        
        $token = $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ]);

        $token = json_decode($token->getContent());

        $response = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->post('/api/comments', [
          'body' => 'Testing',
          'approved' => true,
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
        $permission   = Permission::factory()->create(['name' => 'create comment']);
        $post         = Post::factory()->create();
        $user         = User::factory()->create();

        $user->givePermissionTo('create');
        $token = $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ]);

        $token = json_decode($token->getContent());

        $response = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->post('/api/comments', [
          'body' => 'Testing',
          'approved' => true,
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
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $comment = Comment::factory()->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);

        $post->comments()->save($comment);

        $token = $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ]);

        $token = json_decode($token->getContent());

        $response = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->get('/api/comments');

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_access_comment_detail()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $comment = Comment::factory()->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);
        $post->comments()->save($comment);

        $token = $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ]);

        $token = json_decode($token->getContent());

        $response = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->get("/api/comments/{$comment->id}");

        $response->assertStatus(200);
    }



    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_update_a_comment()
    {
        $permission = Permission::factory()->create(['name' => 'update comment']);
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $comment = Comment::factory()->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);

        $post->comments()->save($comment);

        $user->givePermissionTo('update comment');

        $token = $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ]);

        $token = json_decode($token->getContent());

        $response = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->actingAs($user)->json('PATCH', "/api/comments/{$comment->id}", [
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
        $permission = Permission::factory()->create(['name' => 'delete comment']);
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $user->givePermissionTo('delete comment');

        $comment = Comment::factory()->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);

        $post->comments()->save($comment);

        $token = $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ]);

        $token = json_decode($token->getContent());

        $response = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->json('DELETE', "/api/comments/{$comment->id}");

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_force_delete_a_comment()
    {
        $permission = Permission::factory()->create(['name' => 'delete comment']);
        $permission2 = Permission::factory()->create(['name' => 'force delete comment']);
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $user->givePermissionTo([$permission->name, $permission2->name ]);

        $comment = Comment::factory()->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);

        $post->comments()->save($comment);

        $token = $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ]);

        $token = json_decode($token->getContent());

        $response = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->json('DELETE', "/api/comments/{$comment->id}");

        $response2 = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->json('DELETE', "/api/comments/{$comment->id}");

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
        $permission   = Permission::factory()->create(['name' => 'create comment']);
        $permission2  = Permission::factory()->create(['name' => 'restore comment']);
        $permission3  = Permission::factory()->create(['name' => 'delete comment']);
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $user->givePermissionTo([$permission->name,$permission2->name, $permission3->name]);

        $comment = Comment::factory()->make([
          'user_id' => $user->id,
          'body' => 'testing',
        ]);

        $post->comments()->save($comment);

        $token = $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ]);

        $token = json_decode($token->getContent());

        $delete  = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->json('DELETE', "/api/comments/{$comment->id}");

        $restore = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->json('PUT', "/api/comments-restore/{$comment->id}");

        $delete->assertStatus(200);
        $restore->assertStatus(200);
    }
}
