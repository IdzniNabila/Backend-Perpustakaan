<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Teknologi',
            'Pemrograman',
            'Jaringan',
            'Database',
            'Kecerdasan Buatan'
        ];

        foreach ($data as $kategori) {

            Kategori::create([
                'nama_kategori' => $kategori
            ]);
        }
    }
}