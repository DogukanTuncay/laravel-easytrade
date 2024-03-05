<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function index(Request $request){
        $user = $request->user();
        // Kullanıcı bilgilerini ve pazar yerlerini döndür
        $response = [
            'companyName' => $user->company_name, // Kullanıcının firma adı
            'name' => $user->name, // Kullanıcının adı
            'surname' => $user->surname, // Kullanıcının soyadı
            'email' => $user->email, // Kullanıcının e-posta adresi
            'phoneNumber' => $user->phone, // Kullanıcının telefon numarası
            'marketplace' => [], // Kullanıcının pazar yerleri
        ];
        return response()->json([
            'data' => $response,
            'errors' => '',
            'messages' => '',
            'succeeded' => true,
        ], 200);
    }


}
