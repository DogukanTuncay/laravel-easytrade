<?php

namespace App\Http\Controllers\Api\Product;
use App\Models\Product;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\FileBag;
class ProductController extends Controller
{
    public function index(Request $request)
{
    $company = $request->user();
    // return $this->successResponse(null, 'Hesabınız Aktif Değil. Lütfen Kaydınızın Tamamlanması İçin İlgili Birime Bildirin.');

    if (!$company->id) {
        // return $this->errorResponse('Girilen Hesap Bilgileri Yanlış.');
    }
    $products = Product::where('company_id', $company->id)->get();
    return response()->json([
        'succeeded' => true,
        'message' => 'Products retrieved successfully.',
        'errors' => null,
        'data' => $products
    ], 200);
}

    public function store(ProductRequest $request)
{
    $validated = $request->validated();
    $company = $request->user();

    // Resim dosyası işleme ve şirket ID'ye göre depolama
    if ($request->hasFile('image')) {
        $imageManage = Image::read($request->file('image'));
        $imageManage->resize(1280, 720);
        $companyFolder = sprintf("%06d",  $company->id); // Company ID'yi 6 basamaklı formatta kullan
        if (!file_exists("assets/images/product_images/{$companyFolder}")) {
            mkdir("assets/images/product_images/{$companyFolder}", 0755, true); // Recursive olarak dizin oluştur
        }
        $filename = "assets/images/product_images/{$companyFolder}/". Str::random(10).now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
        $imageManage->save($filename);
        $validated['image_url'] = $filename;
    } else {
        $validated['image_url'] = null; // Eğer dosya yüklenmemişse, image_url null olarak ayarlanır
    }

    $product = Product::create([
        'title' => $validated['title'] ?? null,
        'description' => $validated['description'] ?? null,
        'price' => $validated['price'] ?? 0.00,
        'tax' => $validated['tax'] ?? 20,
        'weight' => $validated['weight'] ?? 0,
        'image_url' => $validated['image_url'],
        'stock_amount' => $validated['stock_amount'],
        'company_id' => $company->id,
        'status' => $validated['status'] ?? true,
    ]);
    return response()->json([
        'succeeded' => true,
        'message' => 'Product created successfully.',
        'errors' => null,
        'data' => $product
    ], 201);
}
 // Ürün güncelle
 public function update(ProductRequest $request,$id)
 {
     $product = Product::find($request->id);
     if (!$product) {
         return response()->json([
             'succeeded' => false,
             'message' => 'Product not found.',
             'errors' => null,
             'data' => null
         ], 404);
     }

     $validated = $request->validated();

     $product->update($validated);
     return response()->json([
         'succeeded' => true,
         'message' => 'Product updated successfully.',
         'errors' => null,
         'data' => $product
     ]);
 }

 // Ürünü sil
 public function destroy($id)
 {

     $product = Product::find($id);
     if (!$product) {
         return response()->json([
             'succeeded' => false,
             'message' => 'Product not found.',
             'errors' => null,
             'data' => null
         ], 404);
     }

     $product->delete();
     return response()->json([
         'succeeded' => true,
         'message' => 'Product deleted successfully.',
         'errors' => null,
         'data' => null
     ]);

 }

    // Ürün detayını getir
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'succeeded' => false,
                'message' => 'Product not found.',
                'errors' => null,
                'data' => null
            ], 404);
        }

        return response()->json([
            'succeeded' => true,
            'message' => 'Product retrieved successfully.',
            'errors' => null,
            'data' => $product
        ]);
    }

}
