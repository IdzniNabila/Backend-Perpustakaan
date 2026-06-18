<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class
        ]);

         $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            BukuSeeder::class,
            AnggotaSeeder::class
        ]);
    }
}