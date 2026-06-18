<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data user lama jika ada agar tidak duplikat
        // User::truncate();

        // Membuat 1 user khusus Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('admin123'), // Otomatis di-hash/enkripsi oleh Laravel
        ]);
    }
}