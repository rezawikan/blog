<?php

namespace App\Http\View\Composers;

use App\Models\Permission;
use Illuminate\View\View;
use App\Repositories\UserRepository;

class PermissionComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $permissions;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(Permission $permissions)
    {
        // Dependencies automatically resolved by service container...
        $this->permissions = $permissions;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('permissions', $this->permissions->get());
    }
}
