<?php

namespace App\Http\Requests\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
            'weight' => 'integer',
            'image' => 'nullable|image|max:5000', // 5MB maksimum dosya boyutu
            'stock_amount' => 'required|integer',
            'status' => 'boolean',

        ];
    }
     protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->__toString(); // Doğrulama hatalarını al
        throw new HttpResponseException(response()->json([
            'succeeded' => false,
            'message' => 'Üründe bir hata oluştu. Lütfen ilgili birime bildirin.',
            'errors' => $errors, // Doğrulama hatalarını dizi olarak döndür
            'data' => null
        ], 400)); // 422 Unprocessable Entity, genellikle doğrulama hataları için kullanılır
    }
}
