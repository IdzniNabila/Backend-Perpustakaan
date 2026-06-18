<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "API Perpustakaan Kampus Digital",
    description: "Dokumentasi API Perpustakaan untuk Tugas Pemrograman Web Semester 4"
)]
#[OA\Server(
    url: "http://localhost:8000/api",
    description: "Server Lokal (Artisan Serve)"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT",
    description: "Masukkan token JWT di sini"
)]
abstract class Controller
{
    // Kosongkan saja bawaan Laravel 11
}