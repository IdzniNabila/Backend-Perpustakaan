namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model {
    protected $fillable = ['peminjaman_id', 'buku_id', 'tanggal_kembali_aktual', 'denda'];
    public function peminjaman() { return $this->belongsTo(Peminjaman::class); }
    public function buku() { return $this->belongsTo(Buku::class); }
}