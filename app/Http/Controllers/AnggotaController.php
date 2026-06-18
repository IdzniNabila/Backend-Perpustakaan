<?php

namespace App\Http\Controllers;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller {
    public function index() { return response()->json(Anggota::all(), 200); }

    public function store(Request $request) {
        $validated = $request->validate([
            'nim' => 'required|string|unique:anggotas,nim',
            'nama' => 'required|string',
            'prodi' => 'required|string',
            'email' => 'required|email'
        ]);
        $anggota = Anggota::create($validated);
        return response()->json(['message' => 'Anggota terdaftar', 'data' => $anggota], 201);
    }

    public function show($id) {
        $anggota = Anggota::find($id);
        return $anggota ? response()->json($anggota, 200) : response()->json(['message' => 'Tidak ditemukan'], 404);
    }

    public function update(Request $request, $id) {
        $anggota = Anggota::find($id);
        if (!$anggota) return response()->json(['message' => 'Tidak ditemukan'], 404);
        $anggota->update($request->all());
        return response()->json(['message' => 'Data Anggota diperbarui', 'data' => $anggota], 200);
    }

    public function destroy($id) {
        $anggota = Anggota::find($id);
        if (!$anggota) return response()->json(['message' => 'Tidak ditemukan'], 404);
        $anggota->delete();
        return response()->json(['message' => 'Anggota dihapus'], 200);
    }
}