<?php

namespace App\Http\Controllers\Api;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnggotaController extends Controller
{
    public function index()
    {
        return response()->json(
            Anggota::with('user')
                ->latest()
                ->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nim' => 'required|unique:anggota,nim',
            'jurusan' => 'required',
            'alamat' => 'required'
        ]);

        $anggota = Anggota::create([
            'user_id' => $request->user_id,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'alamat' => $request->alamat
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Anggota berhasil ditambahkan',
            'data' => $anggota
        ], 201);
    }

    public function show($id)
    {
        $anggota = Anggota::with('user')
            ->findOrFail($id);

        return response()->json($anggota);
    }

    public function update(
        Request $request,
        $id
    ) {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nim' => 'required',
            'jurusan' => 'required',
            'alamat' => 'required'
        ]);

        $anggota->update([
            'user_id' => $request->user_id,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'alamat' => $request->alamat
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Anggota berhasil diupdate',
            'data' => $anggota
        ]);
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);

        $anggota->delete();

        return response()->json([
            'success' => true,
            'message' => 'Anggota berhasil dihapus'
        ]);
    }

    public function search(Request $request)
    {
        $q = $request->q;

        $anggota = Anggota::with('user')
            ->where('nim', 'LIKE', "%$q%")
            ->orWhere('jurusan', 'LIKE', "%$q%")
            ->get();

        return response()->json($anggota);
    }
}