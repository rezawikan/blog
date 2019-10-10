<?php

namespace App\Providers;

use App\Http\View\Composers\PermissionComposer;
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
        View::composer(['roles.create'], PermissionComposer::class);

        // Using Closure based composers...
        View::composer('dashboard', function ($view) {
            //
        });
    }
}
