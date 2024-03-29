<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactFormRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'phone' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->__toString(); // Doğrulama hatalarını al

        throw new HttpResponseException(response()->json([
            'succeeded' => false,
            'message' => 'Doğrulama hatası. Lütfen girdiğiniz bilgileri kontrol edin.',
            'errors' =>  $errors, // Doğrulama hatalarını dizi olarak döndür
            'data' => null
        ], 400)); // 422 Unprocessable Entity, genellikle doğrulama hataları için kullanılır
    }
}
