<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA; // Pembuka library Swagger

class AuthController extends Controller
{
    #[OA\Post(
        path: "/login",
        summary: "Login Admin",
        description: "Endpoint untuk memvalidasi akun admin dan mendapatkan token akses",
        tags: ["Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "email", type: "string", example: "admin@kampus.ac.id"),
                    new OA\Property(property: "password", type: "string", example: "admin123")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Login Berhasil"),
            new OA\Response(response: 401, description: "Kredensial Salah")
        ]
    )]
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username atau password salah!'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ]
        ], 200);
    }

    #[OA\Post(
        path: "/logout",
        summary: "Logout Admin",
        description: "Endpoint untuk menghancurkan token aktif admin",
        tags: ["Authentication"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "Logout Berhasil")
        ]
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil keluar sistem, token dihancurkan.'
        ], 200);
    }
}