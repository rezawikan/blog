<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

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
        $permissionList = ['view permission', 'create permission', 'update permission', 'delete permission'];
        $roleList = ['view role', 'create role', 'update role', 'delete role'];
        $postCategory = ['view post category', 'create post category', 'update post category', 'delete post category', 'force delete post category', 'restore post category'];

        $allPermissions = collect($postPermission)
        ->merge($commentPermission)
        ->merge($tagPermission)
        ->merge($userPermission)
        ->merge($permissionList)
        ->merge($roleList)
        ->merge($postCategory);

        foreach ($allPermissions as $key => $value) {
          factory(Permission::class)->create(['name' => $value]);
        }

        $roleAdmin = factory(Role::class)->create([
          'name' => 'Admin'
        ]);

        $roleTeam = factory(Role::class)->create([
          'name' => 'Team'
        ]);

        $roleDrafter = factory(Role::class)->create([
          'name' => 'User'
        ]);

        $admin = factory(User::class)->create([
          'name' => 'Admin User',
          'email' => 'admin@rezawikan.com',
          'email_verified_at' => now(),
          'password' => Hash::make('secret')
        ]);

        $team = factory(User::class)->create([
          'name' => 'Team User',
          'email' => 'team@rezawikan.com',
          'email_verified_at' => now(),
          'password' => Hash::make('secret')
        ]);

        $drafter = factory(User::class)->create([
          'name' => 'Drafter User',
          'email' => 'drafter@rezawikan.com',
          'email_verified_at' => now(),
          'password' => Hash::make('secret')
        ]);

        $admin->roles()->save($roleAdmin);
        $admin->givePermissionsToRole($roleAdmin, $allPermissions);

        $team->roles()->save($roleTeam);
        $team->givePermissionsToRole($roleTeam, [
          'create post', 'update post', 'delete post', 'restore post',
          'create comment', 'update comment', 'delete comment', 'restore comment',
          'create tag', 'update tag', 'delete tag', 'restore tag',
          'create user', 'update user', 'delete user', 'restore user'
        ]);

        $drafter->roles()->save($roleDrafter);
        $drafter->givePermissionsToRole($roleDrafter, [
          'create comment', 'update comment'
        ]);
    }
}
