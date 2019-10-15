<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the tag.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('view tag') || $user->hasPermissionWithRole('view tag');
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create tag') || $user->hasPermissionWithRole('create tag');
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function update(User $user, $tag)
    {
        return $user->hasPermissionTo('update tag') || $user->hasPermissionWithRole('update tag');
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function delete(User $user, $tag)
    {
        return $user->hasPermissionTo('delete tag') || $user->hasPermissionWithRole('delete tag');
    }

    /**
     * Determine whether the user can restore the tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function restore(User $user, $tag)
    {
        return $user->hasPermissionTo('restore tag') || $user->hasPermissionWithRole('restore tag');
    }

    /**
     * Determine whether the user can permanently delete the tag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function forceDelete(User $user, $tag)
    {
        return $user->hasPermissionTo('force delete tag') || $user->hasPermissionWithRole('force delete tag');
    }
}
