<?php

namespace App\Providers;

use App\Http\View\Composers\RoleComposer;
use App\Http\View\Composers\PostComposer;
use App\Http\View\Composers\CommentComposer;
use App\Http\View\Composers\PermissionComposer;
use App\Http\View\Composers\CategoryComposer;
use App\Http\View\Composers\CategoryParentComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(['roles.create', 'roles.edit', 'users.create', 'users.edit'], PermissionComposer::class);
        View::composer(['permissions.create', 'permissions.edit', 'users.create', 'users.edit'], RoleComposer::class);
        View::composer(['post-categories.create', 'post-categories.edit'], CategoryParentComposer::class);
        View::composer(['comments.create', 'comments.edit'], PostComposer::class);
        View::composer(['comments.create', 'comments.edit'], CommentComposer::class);
        View::composer(['posts.create', 'posts.edit'], CategoryComposer::class);

    }
}
