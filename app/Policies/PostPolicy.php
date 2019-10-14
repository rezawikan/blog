<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create post') || $user->hasPermissionWithRole('create post');
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user, $post)
    {
        return $user->hasPermissionTo('update post') || $post->hasUser($user->id) || $user->hasPermissionWithRole('update post');
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user, $post)
    {
        return $user->hasPermissionTo('delete post') || $post->hasUser($user->id) || $user->hasPermissionWithRole('delete post');
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function restore(User $user, $post)
    {
        return $user->hasPermissionTo('restore post') || $post->hasUser($user->id) || $user->hasPermissionWithRole('restore post');
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, $post)
    {
        return $user->hasPermissionTo('force delete post') || $user->hasPermissionWithRole('force delete post');
    }
}
