<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        Buku::create([
            'kategori_id' => 1,
            'kode_buku' => 'BK001',
            'judul' => 'Laravel 12',
            'penulis' => 'Taylor Otwell',
            'penerbit' => 'Laravel Press',
            'tahun_terbit' => 2025,
            'stok' => 10
        ]);

        Buku::create([
            'kategori_id' => 2,
            'kode_buku' => 'BK002',
            'judul' => 'React Modern',
            'penulis' => 'Meta',
            'penerbit' => 'Meta Inc',
            'tahun_terbit' => 2025,
            'stok' => 15
        ]);
    }
}