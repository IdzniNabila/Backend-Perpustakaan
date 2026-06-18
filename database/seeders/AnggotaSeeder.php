<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        Anggota::updateOrCreate(
            [
                'nim' => '22010001'
            ],
            [
                'user_id' => 1,
                'jurusan' => 'Teknik Informatika',
                'alamat' => 'Pekanbaru'
            ]
        );
    }
}