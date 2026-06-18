<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role'
    ];

    public function anggota()
    {
    return $this->hasOne(
        Anggota::class
    );
    }

    protected $hidden = [
        'password'
    ];
}