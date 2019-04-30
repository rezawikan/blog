<?php

namespace Tests\Feature\Post;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Post;
use App\Models\PostCategory;
use Laravel\Passport\Passport;
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
        $permission   = factory(Permission::class)->create(['name' => 'create post']);
        $postCategory = factory(PostCategory::class)->create();
        $user         = factory(User::class)->create();

        $user->givePermissionTo('create post');
        Passport::actingAs($user);

        $response = $this->post('/api/posts', [
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
    public function test_user_can_access_posts()
    {
        $posts = factory(Post::class, 100)->create();
        $user  = factory(User::class)->create();

        Passport::actingAs($user);

        $response = $this->get('/api/posts');

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_update_a_post()
    {
        $permission   = factory(Permission::class)->create(['name' => 'update post']);
        $postCategory = factory(PostCategory::class)->create();
        $user         = factory(User::class)->create();

        $user->givePermissionTo('update post');

        $post = factory(Post::class)->create();

        Passport::actingAs($user);

        $response = $this->actingAs($user)->json('PATCH', "/api/posts/{$post->id}", [
        'title'            => 'Test One',
        'body'             => 'Lorem ipsum',
        'user_id'          => $user->id,
        'post_category_id' => $postCategory->id,
        'slug'             => str_slug('Test One'),
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
        $permission = factory(Permission::class)->create(['name' => 'delete post']);

        $user = factory(User::class)->create();

        $user->givePermissionTo('delete post');

        $post = factory(Post::class)->create();

        Passport::actingAs($user);

        $response = $this->json('DELETE', "/api/posts/{$post->id}");

        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_force_delete_a_post()
    {
        $permission  = factory(Permission::class)->create(['name' => 'delete post']);
        $permission2 = factory(Permission::class)->create(['name' => 'force delete post']);
        $user = factory(User::class)->create();

        $user->givePermissionTo('delete post');
        $user->givePermissionTo('force delete post');

        $post = factory(Post::class)->create();

        Passport::actingAs($user);

        $response  = $this->json('DELETE', "/api/posts/{$post->id}");
        $response2 = $this->json('DELETE', "/api/posts/{$post->id}");

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
        $permission   = factory(Permission::class)->create(['name' => 'create post']);
        $permission2  = factory(Permission::class)->create(['name' => 'restore post']);
        $postCategory = factory(PostCategory::class)->create();
        $user         = factory(User::class)->create();

        $user->givePermissionTo('create post');
        $user->givePermissionTo('restore post');

        Passport::actingAs($user);

        $response = $this->post('/api/posts', [
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
        $response = $this->json('PUT', "/api/posts-restore/{$post->id}");

        $response->assertStatus(200);
    }
}
