<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class DashboardController extends Controller
{
    public function index()
    {
        // isAdmin değeri 0 olan kullanıcıları sayfalama ile al
        $users = User::where('isAdmin', 0)->orderBy('created_at','DESC')->paginate(10);

        // 'dashboard' view'ını kullanıcılar ile birlikte döndür
        return view('dashboard', compact('users'));
    }
}
