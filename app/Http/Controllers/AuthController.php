namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // Validasi password "kudaterbang" yang sudah di-hash di DB
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Kredensial login salah.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer', 'user' => $user], 200);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Berhasil logout, token dihapus.'], 200);
    }
}