<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any comments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the comment.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('view comment') || $user->hasPermissionWithRole('view comment');
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create comment') || $user->hasPermissionWithRole('create comment');
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function update(User $user, $comment)
    {
        return $user->hasPermissionTo('update comment') || $user->hasComment($comment->id) || $user->hasPermissionWithRole('update comment');
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, $comment)
    {
        return $user->hasPermissionTo('delete comment') || $user->hasComment($comment->id) || $user->hasPermissionWithRole('update comment');
    }

    /**
     * Determine whether the user can restore the comment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function restore(User $user, $comment)
    {
        return $user->hasPermissionTo('restore comment') || $user->hasPermissionWithRole('restore comment');
    }

    /**
     * Determine whether the user can permanently delete the comment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function forceDelete(User $user, $comment)
    {
        return $user->hasPermissionTo('force delete comment') || $user->hasPermissionWithRole('force delete comment');
    }
}
