<?php

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\User\Enums\Roles;
use Modules\User\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\User\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * @param  array|\Spatie\Permission\Contracts\Role|string  ...$roles
     */
    private function assignRole(...$roles): UserFactory
    {
        return $this->afterCreating(fn(User $user) => $user->syncRoles($roles));
    }

    /**
     * Assign the user as an superadmin.
     */
    public function superadmin(): UserFactory
    {
        return $this->assignRole(Roles::SuperAdmin->value);
    }

    /**
     * Assign the user as an admin.
     */
    public function admin(): UserFactory
    {
        return $this->assignRole(Roles::Admin->value);
    }

    /**
     * Assign the user as a user.
     */
    public function user(): UserFactory
    {
        return $this->assignRole(Roles::User->value);
    }
}
