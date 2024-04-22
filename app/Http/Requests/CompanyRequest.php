<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class CompanyRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:companies,email,' . $this->company,
            'phone' => 'required|string|max:255|unique:companies,phone,' . $this->company,
            'status' => 'boolean',
            'open_hour' => 'date_format:H:i',
            'close_hour' => 'date_format:H:i',
            'password' => 'required|string|min:6',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->__toString(); // Doğrulama hatalarını al

        throw new HttpResponseException(response()->json([
            'succeeded' => false,
            'message' => 'Şirket eklerken bir hata oluştu. Lütfen ilgili birime bildirin.',
            'errors' => $errors, // Doğrulama hatalarını dizi olarak döndür
            'data' => null
        ], 400)); // 422 Unprocessable Entity, genellikle doğrulama hataları için kullanılır
    }
}
