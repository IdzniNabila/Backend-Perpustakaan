<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index() { return response()->json(User::all(), 200); }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        return response()->json(['message' => 'Petugas dibuat', 'data' => $user], 201);
    }

    public function show($id) { 
        $user = User::find($id);
        return $user ? response()->json($user, 200) : response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'Tidak ditemukan'], 404);
        
        $data = $request->all();
        if($request->filled('password')) $data['password'] = Hash::make($request->password);
        
        $user->update($data);
        return response()->json(['message' => 'Petugas diperbarui', 'data' => $user], 200);
    }

    public function destroy($id) {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'Tidak ditemukan'], 404);
        $user->delete();
        return response()->json(['message' => 'Petugas dihapus'], 200);
    }
}