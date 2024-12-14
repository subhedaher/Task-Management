<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfAdmins = 20;

        for ($i = 1; $i <= $numberOfAdmins; $i++) {
            Member::factory()->create([
                'name' => 'Member ' . $i,
                'email' => 'member' . $i . '@system.com',
            ]);
        }
    }
}