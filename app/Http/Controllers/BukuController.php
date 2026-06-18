<?php

namespace App\Http\Controllers\Api;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $keyword =
        $request->keyword;

        $buku = Buku::with('kategori')

        ->when(
            $keyword,
            function ($query) use ($keyword)
            {
                $query->where(
                    'judul',
                    'like',
                    "%$keyword%"
                );
            }
        )

        ->latest()
        ->paginate(10);

        return response()->json(
            $buku
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'kategori_id'=>'required',

            'kode_buku'=>'required|unique:buku',

            'judul'=>'required',

            'penulis'=>'required',

            'penerbit'=>'required',

            'tahun_terbit'=>'required',

            'stok'=>'required'
        ]);

        $buku = Buku::create([
            'kategori_id'=>$request->kategori_id,
            'kode_buku'=>$request->kode_buku,
            'judul'=>$request->judul,
            'penulis'=>$request->penulis,
            'penerbit'=>$request->penerbit,
            'tahun_terbit'=>$request->tahun_terbit,
            'stok'=>$request->stok
        ]);

        return response()->json([
            'message'=>'Buku berhasil ditambahkan',
            'data'=>$buku
        ]);
    }

    public function show($id)
    {
        return Buku::with(
            'kategori'
        )->findOrFail($id);
    }

    public function update(
        Request $request,
        $id
    )
    {
        $buku =
        Buku::findOrFail($id);

        $buku->update([
            'kategori_id'=>$request->kategori_id,
            'kode_buku'=>$request->kode_buku,
            'judul'=>$request->judul,
            'penulis'=>$request->penulis,
            'penerbit'=>$request->penerbit,
            'tahun_terbit'=>$request->tahun_terbit,
            'stok'=>$request->stok
        ]);

        return response()->json([
            'message'=>'Buku berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $buku =
        Buku::findOrFail($id);

        $buku->delete();

        return response()->json([
            'message'=>'Buku berhasil dihapus'
        ]);
    }
}