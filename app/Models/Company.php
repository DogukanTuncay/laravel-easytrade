<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Company extends Authenticatable

{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'companies';

    protected $fillable = [
        'title',
        'email',
        'phone',
        'password',
        'status',
        'open_hour',
        'close_hour',
    ];
    protected $guarded = [
        'password',
    ];

    public function companyAreas(){
        return $this->hasMany(CompanyArea::class);
    }

    public function activeUsers() {
        return $this->belongsToMany(User::class, 'active_company_users')
                    ->wherePivot('status', true)
                    ->withPivot('user_id', 'company_id','id')
                    ->select(['users.id', 'users.name', 'users.surname', 'users.email', 'users.phone']);
    }

    public function inactiveUsers() {
        return $this->belongsToMany(User::class, 'active_company_users')
                    ->wherePivot('status', false)
                    ->withPivot('user_id', 'company_id','id')
                    ->select(['users.id', 'users.name', 'users.surname', 'users.email', 'users.phone']);
    }


    public function users() {
        return $this->belongsToMany(User::class, 'user_companies');
    }

    public function orders() {
        return $this->hasMany(UserOrder::class);
    }
}
