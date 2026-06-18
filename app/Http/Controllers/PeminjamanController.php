<?php
namespace App\Http\Controllers;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller {
    public function index() { 
        return response()->json(Peminjaman::with(['anggota', 'user', 'details.buku'])->get(), 200); 
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_harus_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'buku_ids' => 'required|array|min:1', // Frontend mengirim array ID buku yang dipinjam
            'buku_ids.*' => 'required|exists:bukus,id'
        ]);

        return DB::transaction(function () use ($request, $validated) {
            // 1. Buat Induk Transaksi Peminjaman
            $peminjaman = Peminjaman::create([
                'anggota_id' => $validated['anggota_id'],
                'user_id' => auth()->id(), // Otomatis membaca ID Petugas dari token aktif
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_harus_kembali' => $validated['tanggal_harus_kembali'],
                'status' => 'Dipinjam'
            ]);

            // 2. Loop isi buku, masukkan ke tabel detail, & potong stok buku master
            foreach ($validated['buku_ids'] as $bukuId) {
                $buku = Buku::find($bukuId);
                if ($buku->stok < 1) {
                    return response()->json(['message' => "Buku berjudul '{$buku->judul}' sedang kosong!"], 422);
                }

                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id' => $bukuId,
                    'tanggal_kembali_aktual' => null,
                    'denda' => 0
                ]);

                // Kurangi stok master buku
                $buku->decrement('stok');
            }

            return response()->json(['message' => 'Transaksi Peminjaman Berhasil', 'data' => $peminjaman->load('details')], 201);
        });
    }

    public function show($id) {
        $peminjaman = Peminjaman::with(['anggota', 'user', 'details.buku'])->find($id);
        return $peminjaman ? response()->json($peminjaman, 200) : response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
    }

    public function update(Request $request, $id) {
        $peminjaman = Peminjaman::find($id);
        if (!$peminjaman) return response()->json(['message' => 'Tidak ditemukan'], 404);
        $peminjaman->update($validated);
        return response()->json(['message' => 'Status Peminjaman Utama Diperbarui', 'data' => $peminjaman], 200);
    }

    public function destroy($id) {
        $peminjaman = Peminjaman::find($id);
        if (!$peminjaman) return response()->json(['message' => 'Tidak ditemukan'], 404);
        $peminjaman->delete();
        return response()->json(['message' => 'Data Transaksi dihapus'], 200);
    }
}