<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
class LoginController extends Controller
{
    public function login(Request $request)
{
    // 'email' alanını kullanarak kullanıcıyı bul
    $user = User::where('email', $request->email)->first();

    // Kullanıcı bulunamazsa veya şifre eşleşmezse
    if(!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'succeeded' => false, // Giriş başarısız
            'message' => 'The provided credentials are incorrect.',
            'errors' => null,
            'data' => null
        ], 400); // 401 Unauthorized, kimlik doğrulama hatası için kullanılır
    }

    // Kullanıcı için bir token oluştur
    $userToken = $user->createToken($user->email)->plainTextToken;

    // Başarılı giriş yanıtını döndür
    return response()->json([
        'succeeded' => true,
        'message' => 'Login successful.',
        'errors' => null,
        'data' => ['token' => $userToken,
        'expiration' => '',
        'refreshToken' => '',
        ]
    ], 200);
}
    public function register(StoreUserRequest $request)
    {

    // Kullanıcının zaten var olup olmadığını kontrol edin
    $userExists = User::where('email', $request->email)->exists();

    if ($userExists) {
        // Eğer kullanıcı varsa, hata mesajı ile yanıt ver
        return response()->json([
            'succeeded' => 'true',
            'message' => 'Bu kullanıcı adı zaten kayıtlı. Lütfen başka bir istek yollayın.',
            'errors' => null,
            'data' => null
        ], 400); // 400 veya başka uygun bir HTTP hata kodu kullanabilirsiniz
    }

    $user = User::create($request->validated());
    $userToken = $user->createToken($user->id)->plainTextToken;
    $data = [
        'succeeded' => true,
        'message' => ' Kayıt başarıyla Oluşturuldu.',
        'errors' => null,
        'data' => [
            'token' => $userToken,
            'expiration' => '',
            'refreshToken' => '',

        ],
    ];
    return response()->json($data,200);
    }
}
