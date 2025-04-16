<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnums;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Admin',
                'email' => 'admin@topsis.dev',
                'password' => bcrypt('12345678'),
                'role' => UserRoleEnums::SADMIN->value,
            ]
        );
    }
}
