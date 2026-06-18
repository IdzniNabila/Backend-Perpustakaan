<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\AnggotaController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;
use App\Http\Controllers\Api\DashboardController;



    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Kategori
    |--------------------------------------------------------------------------
    */

    Route::apiResource('kategori', KategoriController::class);

    /*
    |--------------------------------------------------------------------------
    | Buku
    |--------------------------------------------------------------------------
    */

    Route::get('/buku/search', [BukuController::class, 'search']);

    Route::apiResource('buku', BukuController::class);

    /*
    |--------------------------------------------------------------------------
    | Anggota
    |--------------------------------------------------------------------------
    */

    Route::apiResource('anggota', AnggotaController::class);

    /*
    |--------------------------------------------------------------------------
    | Peminjaman
    |--------------------------------------------------------------------------
    */

    Route::apiResource('peminjaman', PeminjamanController::class);

    /*
    |--------------------------------------------------------------------------
    | Pengembalian
    |--------------------------------------------------------------------------
    */

    Route::apiResource('pengembalian', PengembalianController::class);
});