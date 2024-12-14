<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
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
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'password' => Hash::make('password')
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Admin $admin) {
            $roleWeb = Role::where('name', 'Super Admin')->where('guard_name', 'admin')->first();
            
            $roleApi = Role::where('name', 'Super Admin')->where('guard_name', 'api-admin')->first();
                $admin->assignRole($roleWeb); 
                $admin->assignRole($roleApi); 
        });
    }
    
}
