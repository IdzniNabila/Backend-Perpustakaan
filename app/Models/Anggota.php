<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'user_id',
        'nim',
        'jurusan',
        'alamat'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function peminjaman()
    {
        return $this->hasMany(
            Peminjaman::class
        );
    }
}