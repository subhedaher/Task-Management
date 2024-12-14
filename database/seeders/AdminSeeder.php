<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfAdmins = 1;

        for ($i = 1; $i <= $numberOfAdmins; $i++) {
            Admin::factory()->create([
                'name' => 'Super Admin',
                'email' => 'superadmin@system.com',
            ]);
        }
    }
}