<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayOfPermissionNames = [
            // Users
            [
                'name' => 'View User',
                'category' => 'User',
            ],
            [
                'name' => 'Create User',
                'category' => 'User',
            ],
            [
                'name' => 'Edit User',
                'category' => 'User',
            ],
            [
                'name' => 'Delete User',
                'category' => 'User',
            ],
        ];

        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission['name'], 'guard_name' => 'web', 'category' => $permission['category']];
        });

        Permission::insert($permissions->toArray());
    }
}
