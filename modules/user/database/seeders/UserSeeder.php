<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Enums\Roles;
use Modules\User\Models\Role;
use Modules\User\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create([
            'name' => Roles::SuperAdmin->value,
        ]);

        Role::create([
            'name' => Roles::Admin->value,
        ]);

        Role::create([
            'name' => Roles::User->value,
        ]);

        $this->call([
            PermissionSeeder::class,
        ]);

        User::factory()->superadmin()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);

        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        User::factory()->user()->create([
            'name' => 'User',
            'email' => 'user@example.com',
        ]);

        User::factory(10)->user()->create();
    }
}
