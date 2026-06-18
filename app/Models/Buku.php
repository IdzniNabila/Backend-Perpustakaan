namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model {
    protected $fillable = ['kategori_id', 'judul', 'penulis', 'penerbit', 'stok'];
    public function kategori() { return $this->belongsTo(Kategori::class); }
}