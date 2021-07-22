<?php

namespace Tests\Unit\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_give_permission_to_user()
    {
        $user = User::factory()->create();
        $permissions = Permission::factory()->create();
        //
        $user->givePermissionTo([$permissions->name]);
        //
        $this->assertInstanceOf(Permission::class, $user->permissions->first());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_give_wrong_permission_to_user()
    {
        $user = User::factory()->create();
        $permissions = Permission::factory()->create();

        $user->givePermissionTo(['none']);
        //
        $this->assertNull($user->permissions->first());
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_detach_permission_to_user()
    {
        $user = User::factory()->create();
        $permissions = Permission::factory()->create();
        //
        $user->givePermissionTo([$permissions->name]);

        $user->detachPermissionTo([$permissions->name]);

        $this->assertSame(null, $user->permissions->first());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_has_permission()
    {
        $user = User::factory()->create();
        $permissions = Permission::factory()->count(10)->create();
        $user->givePermissionTo($permissions->pluck('name'));

        $permission = $permissions->fresh()->first();

        $true = $user->hasPermissionTo($permission->name);

        $this->assertTrue($true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_has_permission_through_role()
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create();
        $role        = Role::factory()->create();

        $role->permissions()->attach([$permission->id]);
        $user->giveRoleTo($role);

        $true = $user->hasPermissionTo($permission);

        $this->assertTrue($true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_has_permission_with_wrong_roles()
    {
        $user        = User::factory()->create();
        $permission1 = Permission::factory()->create(['name' => 'create post']);
        $permission2 = Permission::factory()->create(['name' => 'view post']);
        $role1        = Role::factory()->create();
        $role2        = Role::factory()->create();

        $role1->permissions()->save($permission1);
        $role2->permissions()->save($permission2);

        $user->giveRoleTo($role1->name);

        $false = $user->hasPermissionTo($permission2);

        $this->assertFalse($false);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_has_permission_with_permission_object_through_role()
    {
        $user        = User::factory()->create();
        $permissions = Permission::factory()->create(['name' => 'create post']);
        $roles       = Role::factory()->create(['name' => 'administrator']);

        $roles->permissions()->save($permissions);

        $user->roles()->save($roles);

        $user->givePermissionTo($permissions->pluck('name')->first());

        $true = $user->hasPermissionTo($permissions);

        $this->assertTrue($true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_update_the_permission()
    {
        $user = User::factory()->create();
        $permissions = Permission::factory()->count(10)->create();

        $first  = $permissions->pluck('name')->get(2);
        $second = $permissions->pluck('name')->get(3);
        //
        $user->givePermissionTo($first);
        $user->updatePermission($second);
        $false = $user->hasPermissionTo($permissions->get(2));
        // //
        $this->assertFalse($false);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_has_role()
    {
        $user  = User::factory()->create();
        $roles = Role::factory()->count(10)->create();

        $role = $roles->pluck('name')->get(3);
        $user->giveRoleTo($role);

        $true = $user->hasRole($role);

        $this->assertTrue($true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_has_wrong_role()
    {
        $user  = User::factory()->create();
        $roles = Role::factory()->count(10)->create();

        $role = $roles->pluck('name')->get(3);
        $user->giveRoleTo(['none']);

        $true = $user->hasRole($role);

        $this->assertFalse($true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_can_update_role()
    {
        $user  = User::factory()->create();
        $roles = Role::factory()->count(2)->create();

        $role1 = $roles->pluck('name')->get(0);
        $role2 = $roles->pluck('name')->get(1);

        $user->giveRoleTo($role1);

        $user->updateRole($role2);

        $true = $user->hasRole($role2);


        $this->assertTrue($true);
    }
}
