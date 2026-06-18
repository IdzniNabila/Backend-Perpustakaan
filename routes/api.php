<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route Publik (Bisa diakses siapa saja tanpa membawa token)
Route::post('/login', [AuthController::class, 'login']);

// Route Terproteksi (Hanya bisa diakses jika menyertakan Token Valid)
Route::middleware('auth:sanctum')->group(function () {

Route::get(
    '/anggota/search',
    [AnggotaController::class, 'search']
);

Route::apiResource(
    'anggota',
    AnggotaController::class
);
    
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Nanti jika ada Route CRUD Buku atau Anggota, masukkan di bawah sini:
    // Route::apiResource('buku', BukuController::class);
});