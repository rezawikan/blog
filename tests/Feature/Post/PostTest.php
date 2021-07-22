<?php

namespace Tests\Feature\Post;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostCategory;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Str;
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
    public function test_user_can_create_a_post()
    {
        $permission   = Permission::factory()->create(['name' => 'create post']);
        $postCategory = PostCategory::factory()->create();
        $user         = User::factory()->create();

        $user->givePermissionTo('create post');
        $token = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
          ]);
  
        $token = json_decode($token->getContent());
  
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->post('/api/posts', [
          'title'             => 'Test',
          'body'              => 'Lorem ipsum',
          'post_category_id'  => $postCategory->id,
          'user_id'           => $user->id,
          'slug'              => Str::slug('Lorem ipsum'),
          'image'             => 'default.png',
          'summary'           => 'Lorem ipsum',
          'live'              => true
        ]);

        $response->assertStatus(201);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_not_create_a_post()
    {
        $permission   = Permission::factory()->create(['name' => 'create post']);
        $postCategory = PostCategory::factory()->create();
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
          ])->post('/api/posts', [
          'title'             => 'Test',
          'body'              => 'Lorem ipsum',
          'post_category_id'  => $postCategory->id,
          'user_id'           => $user->id,
          'slug'              => Str::slug('Lorem ipsum'),
          'image'             => 'default.png',
          'summary'           => 'Lorem ipsum',
          'live'              => true
        ]);

        $response->assertStatus(403);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_access_posts()
    {
        $posts = Post::factory()->count(20)->create();
        $user  = User::factory()->create();

        $token = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
          ]);
  
        $token = json_decode($token->getContent());
  
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->get('/api/posts');

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_access_post_detail()
    {
        $post  = Post::factory()->create();
        $user  = User::factory()->create();

        $token = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
          ]);
  
        $token = json_decode($token->getContent());
  
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->get("/api/posts/{$post->id}");

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_skip_access_posts_with_anonymous_scope()
    {
        $tags  = Tag::factory()->count(5)->create();
        $posts = Post::factory()->count(5)->create();
        $user  = User::factory()->create();

        foreach ($posts as $index => $post) {
            $post->tags()->save($tags[$index]);
        }

        $token = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
          ]);
  
        $token = json_decode($token->getContent());
  
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->get('/api/posts?tag[]=testing&none=testing');

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_update_a_post()
    {
        $permission   = Permission::factory()->create(['name' => 'update post']);
        $postCategory = PostCategory::factory()->create();
        $user         = User::factory()->create();

        $user->givePermissionTo('update post');

        $post = Post::factory()->create();

        $token = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
          ]);
  
        $token = json_decode($token->getContent());
  
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->actingAs($user)->json('PATCH', "/api/posts/{$post->id}", [
        'title'            => 'Test One',
        'body'             => 'Lorem ipsum',
        'user_id'          => $user->id,
        'post_category_id' => $postCategory->id,
        'slug'             => Str::slug('Test One'),
        'image'            => 'default.png',
        'summary'          => 'Lorem ipsum',
        'live'             => true
      ]);

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_delete_a_post()
    {
        $permission = Permission::factory()->create(['name' => 'delete post']);

        $user = User::factory()->create();

        $user->givePermissionTo('delete post');

        $post = Post::factory()->create();

        $token = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
          ]);
  
        $token = json_decode($token->getContent());
  
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->json('DELETE', "/api/posts/{$post->id}");

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_force_delete_a_post()
    {
        $permission  = Permission::factory()->create(['name' => 'delete post']);
        $permission2 = Permission::factory()->create(['name' => 'force delete post']);
        $user = User::factory()->create();

        $user->givePermissionTo('delete post');
        $user->givePermissionTo('force delete post');

        $post = Post::factory()->create();

        $token = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
          ]);
  
        $token = json_decode($token->getContent());
  
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->json('DELETE', "/api/posts/{$post->id}");

        $response2 = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->json('DELETE', "/api/posts/{$post->id}");

        $response->assertStatus(200);
        $response2->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_restore_a_post()
    {
        $permission   = Permission::factory()->create(['name' => 'create post']);
        $permission2  = Permission::factory()->create(['name' => 'restore post']);
        $permission3  = Permission::factory()->create(['name' => 'delete post']);
        $postCategory = PostCategory::factory()->create();
        $user         = User::factory()->create();

        $user->givePermissionTo([$permission->name,$permission2->name, $permission3->name]);

        $token = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
          ]);
  
        $token = json_decode($token->getContent());
  
        $store = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->post('/api/posts', [
          'title'            => 'Test',
          'body'             => 'Lorem ipsum',
          'user_id'          => $user->id,
          'post_category_id' => $postCategory->id,
          'slug'             => Str::slug('Lorem ipsum'),
          'image'            => 'default.png',
          'summary'          => 'Lorem ipsum',
          'live'             => true
        ]);

        $post = Post::first();

        $delete  = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->json('DELETE', "/api/posts/{$post->id}");

        $restore = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token->meta->token,
          ])->json('PUT', "/api/posts-restore/{$post->id}");

        $store->assertStatus(201);
        $delete->assertStatus(200);
        $restore->assertStatus(200);
    }
}
