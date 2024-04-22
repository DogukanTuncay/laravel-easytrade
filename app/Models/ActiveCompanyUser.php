<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCompanyUser extends Model
{
    use HasFactory;
    protected $table = 'active_company_users';
    protected $fillable = [
        'user_id',
        'company_id',
        'status',
        'current_latitude',
        'current_longitude',
    ];

    // User ve Company modelleri ile ilişki kurulacak
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
