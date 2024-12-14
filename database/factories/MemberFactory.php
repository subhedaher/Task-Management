<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
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
            'password' => Hash::make('password'),
            'admin_id' => 1,
            'designation_id' => fake()->numberBetween(1, 15),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Member $member) {
            $roleMemberWeb = Role::where('name', 'Member')->where('guard_name' , '=' , 'member')->first();
            $roleMemberApi = Role::where('name', 'Member')->where('guard_name' , '=' , 'api-member')->first();

            $roleProjectManagerWeb = Role::where('name', 'Project Manager')->where('guard_name' , '=' , 'member')->first();
            $roleProjectManagerApi = Role::where('name', 'Project Manager')->where('guard_name' , '=' , 'api-member')->first();
            if ($member->id % 5 == 0) {
                $member->assignRole($roleProjectManagerWeb);
                $member->assignRole($roleProjectManagerApi);
            } else {
                $member->assignRole($roleMemberWeb);
                $member->assignRole($roleMemberApi);
            }
        });
    }
}