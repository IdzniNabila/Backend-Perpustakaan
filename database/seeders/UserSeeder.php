<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'username' => 'admin'
            ],
            [
                'name' => 'Administrator',
                'password' => bcrypt('admin123'),
                'role' => 'admin'
            ]
        );
    }
}