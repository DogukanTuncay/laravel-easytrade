<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyArea extends Model
{
    use HasFactory;
    protected $table = 'company_areas';

    protected $fillable = [
        'title',
        'description',
        'company_id'
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function orders() {
        return $this->hasMany(UserOrder::class);
    }
}
