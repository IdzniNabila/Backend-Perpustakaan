namespace App\Http\Controllers;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller {
    public function index() { return response()->json(Kategori::all(), 200); }

    public function store(Request $request) {
        $validated = $request->validate(['nama_kategori' => 'required|string']);
        $kategori = Kategori::create($validated);
        return response()->json(['message' => 'Kategori ditambahkan', 'data' => $kategori], 201);
    }

    public function show($id) {
        $kategori = Kategori::find($id);
        return $kategori ? response()->json($kategori, 200) : response()->json(['message' => 'Tidak ditemukan'], 404);
    }

    public function update(Request $request, $id) {
        $kategori = Kategori::find($id);
        if (!$kategori) return response()->json(['message' => 'Tidak ditemukan'], 404);
        $kategori->update($request->all());
        return response()->json(['message' => 'Kategori diperbarui', 'data' => $kategori], 200);
    }

    public function destroy($id) {
        $kategori = Kategori::find($id);
        if (!$kategori) return response()->json(['message' => 'Tidak ditemukan'], 404);
        $kategori->delete();
        return response()->json(['message' => 'Kategori dihapus'], 200);
    }
}