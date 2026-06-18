<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'anggota_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status'
    ];

    public function anggota()
    {
        return $this->belongsTo(
            Anggota::class
        );
    }

    public function detail()
    {
        return $this->hasMany(
            DetailPeminjaman::class
        );
    }
}