namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model {
    protected $fillable = ['anggota_id', 'user_id', 'tanggal_pinjam', 'tanggal_harus_kembali', 'status'];
    public function anggota() { return $this->belongsTo(Anggota::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function details() { return $this->hasMany(DetailPeminjaman::class); }
}