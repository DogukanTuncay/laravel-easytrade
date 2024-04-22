<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'phone', 'subject', 'message', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
