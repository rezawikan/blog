<?php

namespace App\Policies;

use App\Models\User;
use App\PostCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any post categories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the post category.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('view post category') || $user->hasPermissionWithRole('view post category');
    }

    /**
     * Determine whether the user can create post categories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create post category') || $user->hasPermissionWithRole('create post category');
    }

    /**
     * Determine whether the user can update the post category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PostCategory  $postCategory
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermissionTo('update post category') || $user->hasPermissionWithRole('update post category');
    }

    /**
     * Determine whether the user can delete the post category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PostCategory  $postCategory
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete post category') || $user->hasPermissionWithRole('delete post category');
    }

    /**
     * Determine whether the user can restore the post category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PostCategory  $postCategory
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->hasPermissionTo('restore post category') || $user->hasPermissionWithRole('restore post category');
    }

    /**
     * Determine whether the user can permanently delete the post category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PostCategory  $postCategory
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->hasPermissionTo('force delete post category') || $user->hasPermissionWithRole('force delete post category');
    }
}
