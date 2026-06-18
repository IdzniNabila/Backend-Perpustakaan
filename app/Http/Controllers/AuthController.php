<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
        use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'message' => 'Email atau password salah!'
        ], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'status' => 'success',
        'message' => 'Login berhasil',
        'token' => $token,
        'user' => $user
    ]);
    }
    public function logout(Request $request)
    {
        // Menghapus token yang sedang digunakan untuk logout
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Berhasil logout, token dihapus.'
        ], 200);
    }
}