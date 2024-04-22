<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    use HasFactory;

    protected $table = 'user_companies';

    protected $fillable = [
        'user_id',
        'company_id',
        'rate',
        'description'
    ];

    // User modeli ile ilişki
    public function user() {
        // Bu ActiveCompanyUser modeli, User modeline bağlıdır
        return $this->belongsTo(User::class, 'user_id');
    }

    // Company modeli ile ilişki
    public function company() {
        // Bu ActiveCompanyUser modeli, Company modeline bağlıdır
        return $this->belongsTo(Company::class, 'company_id');
    }
}
