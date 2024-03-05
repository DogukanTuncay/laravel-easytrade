<?php

namespace App\Http\Controllers;

use App\Models\UserMeta;
use Illuminate\Http\Request;
class UserMetaController extends Controller
{
    public function index()
    {
        $metas = UserMeta::paginate(10); // Sayfalama ekleyerek metaları alıyoruz

        return view('backend.metas.index', compact('metas'));
    }
}
