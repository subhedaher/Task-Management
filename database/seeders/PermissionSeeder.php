<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission Web For Guard Admin Only
        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Settings']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Update-Settings']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Create-Role']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Roles']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Update-Role']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete-Role']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Create-Admin']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Admins']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Update-Admin']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete-Admin']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Create-Department']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Departments']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Update-Department']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete-Department']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Create-Designation']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Designations']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Update-Designation']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete-Designation']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Create-Member']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Members']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Update-Member']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete-Member']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Create-Project']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Projects']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Update-Project']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete-Project']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Create-Task']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Tasks']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Update-Task']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete-Task']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Productivities']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Comments']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete-Comment']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Activities']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Change-Status-Project']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Change-Status-Task']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Read-Attachments']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Delete-Attachment']);

        Permission::create(['guard_name' => 'admin', 'name' => 'Report-Projects']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Report-Tasks']);
        Permission::create(['guard_name' => 'admin', 'name' => 'Report-Members']);

        // Permission Web For Guard Member Only
        Permission::create(['guard_name' => 'member', 'name' => 'Read-Projects']);

        Permission::create(['guard_name' => 'member', 'name' => 'Create-Task']);
        Permission::create(['guard_name' => 'member', 'name' => 'Read-Tasks']);
        Permission::create(['guard_name' => 'member', 'name' => 'Update-Task']);
        Permission::create(['guard_name' => 'member', 'name' => 'Delete-Task']);

        Permission::create(['guard_name' => 'member', 'name' => 'Create-Productivity']);
        Permission::create(['guard_name' => 'member', 'name' => 'Read-Productivities']);
        Permission::create(['guard_name' => 'member', 'name' => 'Update-Productivity']);
        Permission::create(['guard_name' => 'member', 'name' => 'Delete-Productivity']);

        Permission::create(['guard_name' => 'member', 'name' => 'Create-Comment']);
        Permission::create(['guard_name' => 'member', 'name' => 'Read-Comments']);
        Permission::create(['guard_name' => 'member', 'name' => 'Update-Comment']);
        Permission::create(['guard_name' => 'member', 'name' => 'Delete-Comment']);

        Permission::create(['guard_name' => 'member', 'name' => 'Read-Activities']);

        Permission::create(['guard_name' => 'member', 'name' => 'Change-Status-Project']);
        Permission::create(['guard_name' => 'member', 'name' => 'Change-Status-Task']);

        Permission::create(['guard_name' => 'member', 'name' => 'Read-Attachments']);
        Permission::create(['guard_name' => 'member', 'name' => 'Create-Attachment']);
        Permission::create(['guard_name' => 'member', 'name' => 'Delete-Attachment']);

        Permission::create(['guard_name' => 'member', 'name' => 'Report-Tasks']);
        Permission::create(['guard_name' => 'member', 'name' => 'Report-Members']);

        // Permission Api For Guard Admin Only
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Settings']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Update-Settings']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Create-Role']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Roles']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Update-Role']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Delete-Role']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Create-Admin']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Admins']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Update-Admin']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Delete-Admin']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Create-Department']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Departments']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Update-Department']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Delete-Department']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Create-Designation']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Designations']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Update-Designation']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Delete-Designation']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Create-Member']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Members']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Update-Member']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Delete-Member']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Create-Project']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Projects']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Update-Project']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Delete-Project']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Create-Task']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Tasks']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Update-Task']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Delete-Task']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Productivities']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Comments']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Delete-Comment']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Activities']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Change-Status-Project']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Change-Status-Task']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Read-Attachments']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Delete-Attachment']);

        Permission::create(['guard_name' => 'api-admin', 'name' => 'Report-Projects']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Report-Tasks']);
        Permission::create(['guard_name' => 'api-admin', 'name' => 'Report-Members']);

        // Permission Api For Guard Member Only
        Permission::create(['guard_name' => 'api-member', 'name' => 'Read-Projects']);

        Permission::create(['guard_name' => 'api-member', 'name' => 'Create-Task']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Read-Tasks']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Update-Task']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Delete-Task']);

        Permission::create(['guard_name' => 'api-member', 'name' => 'Create-Productivity']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Read-Productivities']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Update-Productivity']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Delete-Productivity']);

        Permission::create(['guard_name' => 'api-member', 'name' => 'Create-Comment']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Read-Comments']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Update-Comment']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Delete-Comment']);

        Permission::create(['guard_name' => 'api-member', 'name' => 'Read-Activities']);

        Permission::create(['guard_name' => 'api-member', 'name' => 'Change-Status-Project']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Change-Status-Task']);

        Permission::create(['guard_name' => 'api-member', 'name' => 'Read-Attachments']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Create-Attachment']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Delete-Attachment']);

        Permission::create(['guard_name' => 'api-member', 'name' => 'Report-Tasks']);
        Permission::create(['guard_name' => 'api-member', 'name' => 'Report-Members']);
    }
}
