<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            PermissionSeeder::class
        );

        $roleAdminWeb = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'admin'
        ]);

        $roleAdminApi = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'api-admin'
        ]);

        $roleProjectManagerWeb = Role::create([
            'name' => 'Project Manager',
            'guard_name' => 'member'
        ]);

        $roleProjectManagerApi = Role::create([
            'name' => 'Project Manager',
            'guard_name' => 'api-member'
        ]);

        $roleMemberWeb = Role::create([
            'name' => 'Member',
            'guard_name' => 'member'
        ]);

        $roleMemberApi = Role::create([
            'name' => 'Member',
            'guard_name' => 'api-member'
        ]);

        $roleMemberWeb->givePermissionTo('Read-Projects');
        $roleMemberWeb->givePermissionTo('Read-Tasks');
        $roleMemberWeb->givePermissionTo('Create-Productivity');
        $roleMemberWeb->givePermissionTo('Read-Productivities');
        $roleMemberWeb->givePermissionTo('Update-Productivity');
        $roleMemberWeb->givePermissionTo('Delete-Productivity');
        $roleMemberWeb->givePermissionTo('Create-Comment');
        $roleMemberWeb->givePermissionTo('Read-Comments');
        $roleMemberWeb->givePermissionTo('Read-Activities');
        $roleMemberWeb->givePermissionTo('Read-Attachments');

        $roleMemberApi->givePermissionTo('Read-Projects');
        $roleMemberApi->givePermissionTo('Read-Tasks');
        $roleMemberApi->givePermissionTo('Create-Productivity');
        $roleMemberApi->givePermissionTo('Read-Productivities');
        $roleMemberApi->givePermissionTo('Update-Productivity');
        $roleMemberApi->givePermissionTo('Delete-Productivity');
        $roleMemberApi->givePermissionTo('Create-Comment');
        $roleMemberApi->givePermissionTo('Read-Comments');
        $roleMemberApi->givePermissionTo('Read-Activities');
        $roleMemberApi->givePermissionTo('Read-Attachments');

        $roleAdminWeb = Role::where('name', '=', 'Super Admin')->where('guard_name', '=', 'admin')->first();
        $roleAdminApi = Role::where('name', '=', 'Super Admin')->where('guard_name', '=', 'api-admin')->first();

        $roleProjectManagerWeb = Role::where('name', '=', 'Project Manager')->where('guard_name', '=', 'member')->first();
        $roleProjectManagerApi = Role::where('name', '=', 'Project Manager')->where('guard_name', '=', 'api-member')->first();

        $permissionsAdminWeb = Permission::where('guard_name', '=', 'admin')->get();
        $permissionsAdminApi = Permission::where('guard_name', '=', 'api-admin')->get();

        $permissionsProjectManagerWeb = Permission::where('guard_name', '=', 'member')->get();
        $permissionsProjectManagerApi = Permission::where('guard_name', '=', 'api-member')->get();

        foreach ($permissionsAdminWeb as $p) {
            $roleAdminWeb->givePermissionTo($p);
        }

        foreach ($permissionsAdminApi as $p) {
            $roleAdminApi->givePermissionTo($p);
        }

        foreach ($permissionsProjectManagerWeb as $p) {
            $roleProjectManagerWeb->givePermissionTo($p);
        }

        foreach ($permissionsProjectManagerApi as $p) {
            $roleProjectManagerApi->givePermissionTo($p);
        }

        $this->call([
            // SettingSeeder::class,
            AdminSeeder::class,
            // DepartmentSeeder::class,
            // DesignationSeeder::class,
            // MemberSeeder::class,
            // ProjectSeeder::class,
            // TaskSeeder::class
        ]);
    }
}
