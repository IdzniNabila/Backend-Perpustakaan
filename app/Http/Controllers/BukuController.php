<?php
namespace App\Http\Controllers;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller {
    public function index() { 
        // Mengambil buku beserta info nama kategorinya (Eager Loading)
        return response()->json(Buku::with('kategori')->get(), 200); 
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'stok' => 'required|integer|min:0'
        ]);
        $buku = Buku::create($validated);
        return response()->json(['message' => 'Buku berhasil dimasukkan', 'data' => $buku], 201);
    }

    public function show($id) {
        $buku = Buku::with('kategori')->find($id);
        return $buku ? response()->json($buku, 200) : response()->json(['message' => 'Buku tidak ditemukan'], 404);
    }

    public function update(Request $request, $id) {
        $buku = Buku::find($id);
        if (!$buku) return response()->json(['message' => 'Tidak ditemukan'], 404);
        $buku->update($request->all());
        return response()->json(['message' => 'Buku diperbarui', 'data' => $buku], 200);
    }

    public function destroy($id) {
        $buku = Buku::find($id);
        if (!$buku) return response()->json(['message' => 'Tidak ditemukan'], 404);
        $buku->delete();
        return response()->json(['message' => 'Buku dihapus'], 200);
    }
}