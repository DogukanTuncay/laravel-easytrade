<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrderProduct extends Model
{
    use HasFactory;
    protected $table = 'user_order_products';

    protected $fillable = [
        'user_id',      // Kullanıcı ID'sini saklamak için eklendi
        'company_id',   // Şirket ID'sini saklamak için eklendi
        'product_id', // Hangi ürün ?
        'price',
        'amount',

    ];


    // Product ile ilişki
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // User ile ilişki
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Company ile ilişki
    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
