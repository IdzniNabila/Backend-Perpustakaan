namespace App\Http\Controllers;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DetailPeminjamanController extends Controller {
    public function index() { return response()->json(DetailPeminjaman::with('buku')->get(), 200); }

    // Proses Pengembalian Buku (Update baris transaksional detail)
    public function update(Request $request, $id) {
        $detail = DetailPeminjaman::with('peminjaman')->find($id);
        if (!$detail) return response()->json(['message' => 'Item tidak ditemukan'], 404);
        if ($detail->tanggal_kembali_aktual != null) return response()->json(['message' => 'Buku ini sudah dikembalikan sebelumnya'], 400);

        $tanggalKembali = Carbon::parse($request->input('tanggal_kembali_aktual', now()->toDateString()));
        $harusKembali = Carbon::parse($detail->peminjaman->tanggal_harus_kembali);
        
        // Kalkulasi Denda Keterlambatan (Misal: Rp 2.000 / hari)
        $denda = 0;
        if ($tanggalKembali->gt($harusKembali)) {
            $selisihHari = $tanggalKembali->diffInDays($harusKembali);
            $denda = $selisihHari * 2000;
        }

        // Jalankan Update Detail & Kembalikan Stok Buku ke Database Master
        $detail->update([
            'tanggal_kembali_aktual' => $tanggalKembali->toDateString(),
            'denda' => $denda
        ]);

        Buku::find($detail->buku_id)->increment('stok');

        // Opsional cek jika semua buku di transaksi ini sudah kembali, ubah status induk jadi 'Selesai'
        $peminjamanId = $detail->peminjaman_id;
        $belumKembali = DetailPeminjaman::where('peminjaman_id', $peminjamanId)->whereNull('tanggal_kembali_aktual')->count();
        if ($belumKembali === 0) {
            Peminjaman::find($peminjamanId)->update(['status' => 'Selesai']);
        }

        return response()->json([
            'message' => 'Buku Berhasil Dikembalikan!',
            'denda_keterlambatan' => $denda,
            'data' => $detail
        ], 200);
    }

    public function show($id) { return response()->json(DetailPeminjaman::find($id), 200); }
    public function store(Request $request) { return response()->json(['message' => 'Gunakan endpoint /peminjaman untuk input awal'], 405); }
    public function destroy($id) { return response()->json(['message' => 'Penghapusan partial dilarang'], 405); }
}