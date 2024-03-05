<?php

namespace App\Http\Controllers;
use App\Models\ContactForm;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function index()
    {
        $contactForms = ContactForm::paginate(10); // Sayfalama ekleyerek iletişim formu kayıtlarını alıyoruz

        return view('backend.contactForms.index', compact('contactForms'));
    }
}
