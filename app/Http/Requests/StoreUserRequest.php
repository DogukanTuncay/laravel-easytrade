<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'user_type' => 'string',
            'token' => 'numeric',
            'company_name' => 'nullable|string|max:255', // Firma adı isteğe bağlı ve maksimum 255 karakter olabilir
            'firma_calisan_sayisi' => 'nullable|integer|min:1', // Firma çalışan sayısı isteğe bağlı, tam sayı ve en az 1 olmalı
            'mail_api_key' => 'nullable|string',
            'avatar_id' => 'nullable|numeric',
            'email' => 'required|string|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'mail_activate' => 'boolean',
            'wp_activate' => 'boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->__toString(); // Doğrulama hatalarını al

        throw new HttpResponseException(response()->json([
            'succeeded' => false,
            'message' => 'Doğrulama hatası. Lütfen girdiğiniz bilgileri kontrol edin.',
            'errors' => $errors, // Doğrulama hatalarını dizi olarak döndür
            'data' => null
        ], 400)); // 422 Unprocessable Entity, genellikle doğrulama hataları için kullanılır
    }
}
