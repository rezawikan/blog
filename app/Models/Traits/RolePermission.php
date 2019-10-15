<?php

namespace App\Model\Traits;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Collection;

trait RolePermission
{

    /**
     * Cheking has role
     * @param  array  $roles include string and number in array
     * @return boolean        [description]
     */
    public function hasPermissionWithRole($permission)
    {
        $roles = $this->roles()->get();

        if (is_array($permission)) {
            return $this->hasMultiPermissionWithRole($permission, $roles);
        }

        foreach ($roles as $key => $value) {
          $result = $value->permissions->pluck('name')->contains($permission);
          if ($result) {
              return true;
          }
        }
        return false;
    }

    protected function hasMultiPermissionWithRole($permissions, $roles)
    {
        foreach ($roles as $key => $value) {
          foreach ($permissions as $permission) {
              $result = $value->permissions->pluck('name')->contains($permission);
              if ($result) {
                  return true;
              }
          }
        }
        return false;
    }

    /**
     * Action to give roles to user
     * @param  array $roles (pluck name)
     * @return $this
     */
    public function givePermissionsToRole($role, ...$permissions)
    {
        $permissions = $this->getAllPermissions(array_flatten($permissions));
        // is empty on object permission
        if ($permissions instanceof Collection && $permissions->isEmpty()) {
            return $this;
        }

        $role->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * Action to give perimissions to user
     * @param  array $permissions (pluck name)
     * @return $this
     */
    public function givePermissionTo(...$permissions)
    {

        $permissions = $this->getAllPermissions(array_flatten($permissions));
        // is empty on object permission
        if ($permissions instanceof Collection && $permissions->isEmpty()) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * Action to detach permission on user
     * @param  array $permissions
     * @return $this
     */
    public function detachPermissionTo(...$permissions)
    {
        $permissions = $this->getAllPermissions(array_flatten($permissions));

        $this->permissions()->detach($permissions);

        return $this;
    }

    /**
     * Action to update all permissions
     * @param  array $permissions include all permissions
     * @return $this
     */
    public function updatePermission($permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

    /**
     * Action to checking the permissions
     * @param  array/string  $permission
     * @return boolean
     */
    public function hasPermissionTo($permission)
    {
        if ($permission instanceof Permission) {
            return $this->hasPermissionThroughRole($permission);
        }

        if (is_array($permission)) {
            return $this->hasPermissionIn($permission);
        }

        return $this->hasPermission($permission);
    }

    /**
     * Action to give roles to user
     * @param  array $roles (pluck name)
     * @return $this
     */
    public function giveRoleTo(...$roles)
    {
        $roles = $this->getAllRoles(array_flatten($roles));
        // is empty on object roles
        if ($roles->isEmpty()) {
            return $this;
        }

        $this->roles()->saveMany($roles);

        return $this;
    }

    /**
     * Action to update all roles
     * @param  array $roles include all roles
     * @return $this
     */
    public function updateRole($roles)
    {
        $this->roles()->detach();

        return $this->giveRoleTo($roles);
    }

    /**
     * Action to checking the permissions with the array value
     * @param  array   $permission
     * @return boolean
     */
    protected function hasPermissionThroughRole($permission)
    {
        if ($permission->roles->isEmpty()) {
            return false;
        }

        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Action to checking the permissions with the string/number value
     * @param  string/number  $permission [description]
     * @return boolean
     */
    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission)->count();
    }

    /**
     * Action to checking the permissions with the string/number value
     * @param  string/number  $permission [description]
     * @return boolean
     */
    protected function hasPermissionIn($permissions)
    {
        return (bool) $this->permissions->whereIn('name', $permissions)->count();
    }

    /**
     * Get all permissions with the match name
     * @param  array  $permissions [description]
     * @return /App/Models/Permission
     */
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }

    /**
     * Get all permissions with the match name
     * @param  array  $permissions [description]
     * @return /App/Models/Permission
     */
    protected function getAllRoles(array $roles)
    {
        return Role::whereIn('name', $roles)->get();
    }

    /**
     * Cheking has role
     * @param  array  $roles include string and number in array
     * @return boolean        [description]
     */
    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * [roles description]
     * @return [type] [description]
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    /**
     * [permissions description]
     * @return [type] [description]
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_users');
    }
}
