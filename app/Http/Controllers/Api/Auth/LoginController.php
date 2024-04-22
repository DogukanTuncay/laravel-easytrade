<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Responses\ApiResponse;

class LoginController extends Controller
{
    use ApiResponse;
    public function login(Request $request)
{
    // 'email' alanını kullanarak kullanıcıyı bul
    $login = $request->email; // 'email' adındaki girdiyi al

    // E-posta adresi formatında mı kontrol et
    $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

    // Kullanıcıyı belirtilen alana göre bul
    $user = User::where($fieldType, $login)->first();

    // Kullanıcı bulunamazsa veya şifre eşleşmezse
    if(!$user || !Hash::check($request->password, $user->password)) {
        return $this->errorResponse('The provided credentials are incorrect.');
    }

    // Kullanıcı için bir token oluştur
    $userToken = $user->createToken($user->email)->plainTextToken;
    $data['token'] = $userToken;
    return $this->successResponse($data, 'Login successful.');

}
    public function register(StoreUserRequest $request)
    {

    // Kullanıcının zaten var olup olmadığını kontrol edin
    $userExists = User::where('email', $request->email)->exists();

    if ($userExists) {
        // Eğer kullanıcı varsa, hata mesajı ile yanıt ver
        return $this->errorResponse('Bu kullanıcı zaten kayıtlı. Lütfen başka bir şey yollayın.');
    }

    $user = User::create($request->validated());

    $userToken = $user->createToken($user->id)->plainTextToken;
    $data['token'] = $userToken;
    return $this->successResponse($data, 'Kayıt başarıyla Oluşturuldu.');

    return response()->json($data,200);
    }
}
