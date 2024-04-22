<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserMetaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'company_name' => 'required|string|max:255',
            'company_city' => 'required|string|max:255',
            'company_district' => 'required|string|max:255',
            'company_neighbourhood' => 'required|string|max:255',
            'company_budget' => 'required|numeric',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->__toString(); // Doğrulama hatalarını al

        throw new HttpResponseException(response()->json([
            'data' => null,
            'errors' => $errors, // Doğrulama hatalarını dizi olarak döndür
            'messages' => 'Validation errors occurred.', // Genel hata mesajı
            'succeeded' => false, // İşlem başarısız
        ], 400)); // 422 Unprocessable Entity HTTP status kodu
    }
}
