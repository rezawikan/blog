<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class ACLTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postPermission = ['view post', 'create post', 'update post', 'delete post', 'force delete post', 'restore post'];
        $commentPermission = ['view comment', 'create comment', 'update comment', 'delete comment', 'force delete comment', 'restore comment'];
        $tagPermission = ['view tag', 'create tag', 'update tag', 'delete tag', 'force delete tag', 'restore tag'];
        $userPermission = ['view user', 'create user', 'update user', 'delete user', 'force delete user', 'restore user'];
        $permissionList = ['view permission', 'create permission', 'update permission', 'delete permission', 'force delete permission', 'restore permission'];
        $roleList = ['view role', 'create role', 'update role', 'delete role', 'force delete role', 'restore role'];
        $postCategory = ['view post category', 'create post category', 'update post category', 'delete post category', 'force delete post category', 'restore post category'];

        $allPermissions = collect($postPermission)
        ->merge($commentPermission)
        ->merge($tagPermission)
        ->merge($userPermission)
        ->merge($permissionList)
        ->merge($roleList)
        ->merge($postCategory);

        foreach ($allPermissions as $key => $value) {
            Permission::factory()->create(['name' => $value]);
        }

        $roleSuperAdmin = Role::factory()->create([
          'name' => 'Super Admin'
        ]);

        $roleAdmin = Role::factory()->create([
          'name' => 'Admin'
        ]);

        $roleTeam = Role::factory()->create([
          'name' => 'Team'
        ]);

        $roleUser = Role::factory()->create([
          'name' => 'User'
        ]);

        $superadmin = User::factory()->create([
          'name' => 'Admin User',
          'email' => 'superadmin@rezawikan.com',
          'email_verified_at' => now(),
          'password' => Hash::make('secret')
        ]);

        $admin = User::factory()->create([
          'name' => 'Admin User',
          'email' => 'admin@rezawikan.com',
          'email_verified_at' => now(),
          'password' => Hash::make('secret')
        ]);

        $team = User::factory()->create([
          'name' => 'Team User',
          'email' => 'team@rezawikan.com',
          'email_verified_at' => now(),
          'password' => Hash::make('secret')
        ]);

        $user = User::factory()->create([
          'name' => 'User',
          'email' => 'user@rezawikan.com',
          'email_verified_at' => now(),
          'password' => Hash::make('secret')
        ]);

        $superadmin->roles()->save($roleSuperAdmin);
        $superadmin->givePermissionsToRole($roleSuperAdmin, $allPermissions);

        $admin->roles()->save($roleAdmin);
        $admin->givePermissionsToRole($roleAdmin, [
          'view post', 'create post', 'update post', 'delete post',
          'view comment', 'create comment', 'update comment', 'delete comment',
          'view tag', 'create tag', 'update tag', 'delete tag',
          'view user', 'create user', 'update user', 'delete user',
          'view permission', 'create permission', 'update permission', 'delete permission',
          'view role', 'create role', 'update role', 'delete role',
          'view post category', 'create post category', 'update post category', 'delete post category'
        ]);

        $team->roles()->save($roleTeam);
        $team->givePermissionsToRole($roleTeam, [
          'create post', 'update post',
          'create comment', 'update comment',
          'create tag', 'update tag',
          'create user', 'update user'
        ]);

        $user->roles()->save($roleUser);
        // $user->givePermissionsToRole($roleUser, [
        //   'create comment', 'update comment'
        // ]);
    }
}
