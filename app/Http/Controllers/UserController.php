<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function show($id)
{
     // Kullanıcıyı, metas ve contactForms ilişkileriyle birlikte yükle
     $user = User::with(['metas', 'contactForms'])->findOrFail($id);

    // 'users.show' view'ını kullanıcı bilgisi ile birlikte döndür
    return view('backend.users.show', compact('user'));
}
}
