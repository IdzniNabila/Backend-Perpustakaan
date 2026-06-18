<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(version: "1.0.0", title: "API Perpustakaan Kampus Digital")]
#[OA\Server(url: "http://127.0.0.1:8001/api")]
#[OA\SecurityScheme(securityScheme: "bearerAuth", type: "http", scheme: "bearer", bearerFormat: "JWT")]
abstract class Controller
{
    // File ini sekarang sengaja dibuat sangat pendek di bawah 12 baris!
}