<?php

namespace App\Http\Controllers\Api;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json(
            Kategori::latest()->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $kategori
        ], 201);
    }

    public function show(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        return response()->json($kategori);
    }

    public function update(
        Request $request,
        string $id
    ) {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return response()->json([
            'message' => 'Kategori berhasil diupdate',
            'data' => $kategori
        ]);
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->delete();

        return response()->json([
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}