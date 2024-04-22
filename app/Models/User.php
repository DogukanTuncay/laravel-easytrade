<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Group;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','surname', 'password', 'user_type','company_worker_count','company_name', 'avatar_id', 'token', 'mail_api_key', 'email', 'phone', 'mail_activate', 'wp_activate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'is_admin',
        'remember_token',
        'pivot'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function contactForms()
    {
        return $this->hasMany(ContactForm::class);
    }
    public function metas()
    {
        return $this->hasMany(UserMeta::class);
    }
    public function isAdmin()
    {
        return $this->isAdmin; // `is_admin` sütunu boolean bir değer taşıyor olmalı
    }
}
