<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DetailPeminjamanController;

// Endpoint Publik (Tanpa Token)
Route::post('/login', [AuthController::class, 'login']);

// Endpoint Terproteksi (Wajib membawa Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // 6 API Resource untuk Full CRUD Endpoints
    Route::apiResource('users', UserController::class);
    Route::apiResource('kategoris', KategoriController::class);
    Route::apiResource('bukus', BukuController::class);
    Route::apiResource('anggotas', AnggotaController::class);
    Route::apiResource('peminjamans', PeminjamanController::class);
    Route::apiResource('detail-peminjamans', DetailPeminjamanController::class);
});

