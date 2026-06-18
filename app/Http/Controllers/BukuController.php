<?php

namespace App\Http\Controllers\Api;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BukuController extends Controller
{
    public function index()
    {
        return response()->json(
            Buku::with('kategori')
                ->latest()
                ->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'kode_buku' => 'required|unique:buku',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'stok' => 'required'
        ]);

        $cover = null;

        if ($request->hasFile('cover')) {

            $cover = $request
                ->file('cover')
                ->store(
                    'cover',
                    'public'
                );
        }

        $buku = Buku::create([
            'kategori_id' => $request->kategori_id,
            'kode_buku' => $request->kode_buku,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'cover' => $cover
        ]);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data' => $buku
        ], 201);
    }

    public function show(string $id)
    {
        return Buku::with('kategori')
            ->findOrFail($id);
    }

    public function update(
        Request $request,
        string $id
    ) {

        $buku = Buku::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('cover')) {

            $data['cover'] = $request
                ->file('cover')
                ->store(
                    'cover',
                    'public'
                );
        }

        $buku->update($data);

        return response()->json([
            'message' => 'Buku berhasil diupdate',
            'data' => $buku
        ]);
    }

    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);

        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ]);
    }

    public function search(Request $request)
    {
        return Buku::with('kategori')
            ->where(
                'judul',
                'LIKE',
                "%{$request->q}%"
            )
            ->get();
    }
}