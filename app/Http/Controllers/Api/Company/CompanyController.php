<?php

namespace App\Http\Controllers\Api\Company;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Responses\ApiResponse;
use App\Models\ActiveCompanyUser;
use Illuminate\Validation\ValidationException;

/*TODO Burası tamamen düzenlenicek
*  Yeni Request oluştur, validateleri ve dönüşleri düzenle. Resim varsa ayarla.
*
*/
class CompanyController extends Controller
{
    use ApiResponse;

    // Şirketleri listele
    public function index()
    {
        $companies = Company::all();
        return $this->successResponse($companies, 'Companies retrieved successfully.');
    }

    // Şirket detayını getir
    public function show(Request $request)
    {
        $company = $request->user();
        if (!$company) {

            return $this->errorResponse('Company not found.');

        }

        return $this->successResponse($company, 'Company retrieved successfully.');
    }

    // Şirketi güncelle
    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'status' => 'boolean',
            'open_hour' => 'date_format:H:i',
            'close_hour' => 'date_format:H:i',
            'password' => 'required|string|min:6',
        ]);
        $company = $request->user();
        if (!$company) {
            return $this->errorResponse('Company not found.');
        }


        $company->update($validated);

        return $this->successResponse($company, 'Company updated successfully.');

    }

    // Şirketi sil
    public function destroy(Request $request)
    {
        $company = $request->user();

        if (!$company) {
            return $this->errorResponse('Company not found.');
        }

        $company->delete();
        return $this->successResponse($company, 'Company deleted successfully.');

    }

    public function register(CompanyRequest $request)
    {
        // Gelen verileri doğrula
        $validatedData = $request->validated();
        // Yeni şirket oluştur
        $company = Company::create([
            'title' => $validatedData['title'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
            'status' => $validatedData['status'] ?? false,
            'open_hour' => $validatedData['open_hour'] ?? null,
            'close_hour' => $validatedData['close_hour']?? null,
        ]);

        // Şirket için bir token oluştur
        // $companyToken = $company->createToken('CompanyToken')->plainTextToken;

        // Başarılı kayıt yanıtını döndür
        return $this->successResponse(null, 'Registration successfull.');

    }

    public function login(Request $request)
{
    // 'email' ya da 'phone' alanını kullanarak şirketi bul
    $login = $request->email; // 'email' adındaki girdiyi al, bu email veya telefon numarası olabilir.

    // E-posta adresi veya telefon numarası formatında mı kontrol et
    $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    // Şirketi belirtilen alana göre bul
    $company = Company::where($fieldType, $login)->first();

    // Şirket bulunamazsa veya şifre eşleşmezse
    if (!$company || !Hash::check($request->password, $company->password)) {
        return $this->errorResponse('Girilen Hesap Bilgileri Yanlış.');
    }
    if($company->status == 0){
        return $this->successResponse(null, 'Hesabınız Aktif Değil. Lütfen Kaydınızın Tamamlanması İçin İlgili Birime Bildirin.');
    }
    // Şirket için bir token oluştur
    $companyToken = $company->createToken('CompanyLogin')->plainTextToken;
    $data['token'] = $companyToken;
    $data['company_id'] = $company->id*2;
    // Başarılı giriş yanıtını döndür
    return $this->successResponse($data,'Başarıyla giriş yapıldı. Yönlendirme yapılıyor.');
    }

    public function hashCompanyId(Request $request ){
    $data['encryptedCompanyId'] = $request->company_id*2;
    return $this->successResponse($data,'Başarıyla Şirket Bulundu.');
    }

    public function activeUsers(Request $request){
        try {

        $company = $request->user();
        $activeUsers = $company->activeUsers()->get();
        // $inActiveUsers = $company->inActiveUsers()->get();

        return $this->successResponse($activeUsers,'Başarıyla Tesise Giriş Yapmış  Kullanıcılar Bulundu.');

        } catch (\Throwable $th) {

            return $this->errorResponse("Bir Sorun Oluştu. Hata :".$th);

        }
    }
    public function inactiveUsers(Request $request){

        try {

        $company = $request->user();
        $inactiveUsers = $company->inActiveUsers()->get();

        return $this->successResponse($inactiveUsers,'Başarıyla  Onay Bekleyen Kullanıcılar Bulundu.');

    } catch (\Throwable $th) {

        return $this->errorResponse("Bir Sorun Oluştu. Hata :".$th);

    }
    }
    public function changeStatus(Request $request){

        try {

        $acceptedUser = ActiveCompanyUser::find($request->id);
        $acceptedUser->status = !$acceptedUser->status;
        $acceptedUser->save();

        return $this->successResponse(null,'Başarıyla Durum Değiştirildi.');

    } catch (\Throwable $th) {

        return $this->errorResponse("Bir Sorun Oluştu. Hata :".$th);

    }
    }

    public function userLogout(Request $request){
        try {
            //code...
        $user = ActiveCompanyUser::find($request->id);
        if(empty($user)){
            return $this->errorResponse("Tesiste Böyle Bir Kullanıcı yok ");

        }
        $user->delete();
        return $this->successResponse(null,'Kullanıcı Başarıyla Tesisten Çıkış Yaptı.');
        } catch (\Throwable $th) {
            return $this->errorResponse("Kullanıcı Tesisten Çıkış Yaparken Bir Sorun Oluştu. Hata :".$th);

        }

    }
}
