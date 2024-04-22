<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'price',
     'tax', 'weight', 'image_url', 'stock_amount','company_id', 'status'];

    public function orders() {
        return $this->belongsToMany(UserOrder::class, 'user_order_products');
    }
    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }
}
