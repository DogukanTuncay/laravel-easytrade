<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActiveCompanyUser;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Models\UserCompany;

class UserController extends Controller
{
    use ApiResponse;
    public function index(Request $request){
        $user = $request->user();
        // Kullanıcı bilgilerini ve pazar yerlerini döndür
        $response = [
            'id' => $user->id,
            'name' => $user->name, // Kullanıcının adı
            'surname' => $user->surname, // Kullanıcının soyadı
            'email' => $user->email, // Kullanıcının e-posta adresi
            'phoneNumber' => $user->phone, // Kullanıcının telefon numarası
        ];
    return $this->successResponse($response, 'İşlem Başarılı.');
    }

    public function delete(Request $request)
    {
        $user = $request->user();

        try {
            // Kullanıcıyı sil
            $user->delete();

            // Başarılı yanıt döndür
    return $this->successResponse(null, 'User successfully deleted.');
        } catch (\Exception $e) {
            // Hata durumunda yanıt döndür
        return $this->errorResponse('An error occurred while deleting the user.');
        }
    }

    public function loginCompany(Request $request){
        $user = $request->user();

        if(is_null($user)){
            return $this->errorResponse('User is not authenticated.');
        }
        $company = Company::find($request->company_id);
        if (is_null($company)) {
            return $this->errorResponse('Company does not exist.');
        }

        // Kullanıcının şirket için aktif bir rolü olup olmadığını kontrol et
        $existingActiveUser = ActiveCompanyUser::where('user_id', $user->id)->first();

        if ($existingActiveUser) {
            return $this->errorResponse('Kullanıcı zaten bir tesise giriş yapmış.');
        }

        $activeUser = ActiveCompanyUser::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
        ]);
        $activeUser->save();
        return $this->successResponse(null, 'Login to Company Successfully.');
    }

    public function logoutCompany(Request $request){
        $user = $request->user();

        if (is_null($user)) {
            return $this->errorResponse('User is not authenticated.');
        }

        $company = Company::find($request->company_id);
        if (is_null($company)) {
            return $this->errorResponse('Company does not exist.');
        }

        // Kullanıcının şirket için aktif bir rolünü bul
        $activeUser = ActiveCompanyUser::where('user_id', $user->id)
                                       ->where('company_id', $company->id)
                                       ->first();
        if (!$activeUser) {
            return $this->errorResponse('Kullanıcı bu tesiste aktif bir girişi bulunmamaktadır.');
        }

        // Aktif kullanıcı kaydını sil
        if($activeUser->delete()){
            return $this->successResponse(null, 'Successfully logged out from the company.');
        } else {
            return $this->errorResponse('An error occurred while trying to log out from the company.');
        }
    }
}
