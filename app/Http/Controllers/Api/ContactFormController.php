<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactForm;
use App\Http\Requests\ContactFormRequest;
class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactForms = ContactForm::all();
        return response()->json([
            'data' => $contactForms,
            'errors' => null,
            'messages' => 'Contact forms retrieved successfully.',
            'succeeded' => true,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactFormRequest $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);
        $user = $request->user();
         // `user_id`'yi manuel olarak ayarlayarak yeni ContactForm kaydını oluştur
        $contactForm = ContactForm::create([
        'email' => $request->email,
        'phone' => $request->phone,
        'subject' => $request->subject,
        'message' => $request->message,
        'user_id' => $user->id, // Oturum açmış kullanıcının ID'si
    ]);

    // İstenen formatta yanıt döndür
    return response()->json([
        'data' => $contactForm, // Başarılı işlem sonucu oluşturulan kaydın bilgileri
        'errors' => null, // Hata yoksa null
        'messages' => 'Contact form submitted successfully.', // Başarılı işlem mesajı
        'succeeded' => true, // İşlemin başarı durumu
    ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contactForm = ContactForm::findOrFail($id);
        return response()->json([
            'data' => $contactForm,
            'errors' => null,
            'messages' => 'Contact form retrieved successfully.',
            'succeeded' => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    public function userForms(Request $request)
    {
        $user = $request->user();

        // Kullanıcının iletişim formlarını sorgula
        $contactForms = $user->contactForms()->get();

        // İstenen yapıda yanıt döndür
        return response()->json([
            'data' => $contactForms,
            'errors' => null,
            'messages' => 'User contact forms retrieved successfully.',
            'succeeded' => true,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ContactFormRequest $request, $id)
    {
        $contactForm = ContactForm::findOrFail($id);

        $validatedData = $request->validate([
            'email' => 'email',
            'phone' => 'string',
            'subject' => 'string|max:255',
            'message' => 'string'
        ]);

        $contactForm->update($validatedData);

        return response()->json([
            'data' => $contactForm,
            'errors' => null,
            'messages' => 'Contact form updated successfully.',
            'succeeded' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contactForm = ContactForm::findOrFail($id);
        $contactForm->delete();

        return response()->json([
            'data' => null,
            'errors' => null,
            'messages' => 'Contact form deleted successfully.',
            'succeeded' => true,
        ]);
    }
}
