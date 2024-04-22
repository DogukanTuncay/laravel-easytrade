<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    use HasFactory;
    protected $table = 'user_orders';

    protected $fillable = [
        'user_id',
        'company_id',
        'total_price',
        'location_latitude',
        'location_longitude',
        'company_area_id',
        'description'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function companyArea() {
        return $this->belongsTo(CompanyArea::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'user_order_products');
    }
}
