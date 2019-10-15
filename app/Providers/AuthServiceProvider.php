<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Permission;
use App\Models\PostCategory;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\TagPolicy;
use App\Policies\CommentPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PostCategoryPolicy;
use App\Policies\RolePolicy;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        PostCategory::class => PostCategoryPolicy::class,
        User::class => UserPolicy::class,
        Tag::class => TagPolicy::class,
        Comment::class => CommentPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
