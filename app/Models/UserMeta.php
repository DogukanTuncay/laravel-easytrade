<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'company_name', 'company_city', 'company_district', 'company_neighbourhood', 'company_budget'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
