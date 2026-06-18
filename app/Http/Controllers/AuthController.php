<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        return response()->json(['message' => 'HALO, INI CONTROLLER BARU!']);
        // 1. Validasi input wajib email dan password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // 3. Cek apakah user ada dan password-nya cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Kredensial login admin salah.'
            ], 401);
        }

        // 4. Generate Token Sanctum jika data benar
        $token = $user->createToken('admin_token')->plainTextToken;

        // 5. Kembalikan respons sukses beserta tokennya
        return response()->json([
            'message' => 'Login Berhasil!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
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