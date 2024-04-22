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
            'email' => 'required|string|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
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
