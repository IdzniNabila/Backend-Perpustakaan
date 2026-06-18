<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0", 
    title: "API Perpustakaan Kampus Digital",
    description: "Dokumentasi API untuk Backend Sistem Perpustakaan - Tugas Pemrograman Web"
)]
#[OA\Server(
    url: "http://127.0.0.1:8001/api", 
    description: "Server Lokal (Development)"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT",
    description: "Masukkan Token JWT kamu di sini untuk mengakses API yang diproteksi"
)]
abstract class Controller
{
    // Base Controller Kosong
}