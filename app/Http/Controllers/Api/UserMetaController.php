<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserMeta;
use App\Http\Requests\StoreUserMetaRequest;
class UserMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userMetas = UserMeta::all();
        return response()->json([
            'data' => $userMetas,
            'errors' => null,
            'messages' => 'User metas retrieved successfully.',
            'succeeded' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserMetaRequest $request)
    {
        $validatedData = $request->validated(); // Doğrulanmış verileri al
        $user = $request->user(); // Şu anki oturum açmış kullanıcıyı al

    // Doğrulanmış verilere user_id ekleyerek yeni bir UserMeta kaydı oluştur
    $userMeta = UserMeta::create(array_merge($validatedData, ['user_id' => $user->id]));
        return response()->json([
            'data' => $userMeta,
            'errors' => null,
            'messages' => 'User meta created successfully.',
            'succeeded' => true,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userMeta = UserMeta::findOrFail($id);
        return response()->json([
            'data' => $userMeta,
            'errors' => null,
            'messages' => 'User meta retrieved successfully.',
            'succeeded' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserMetaRequest $request, $id)
    {
        $userMeta = UserMeta::findOrFail($id);
        $userMeta->update($request->validated());

        return response()->json([
            'data' => $userMeta,
            'errors' => null,
            'messages' => 'User meta updated successfully.',
            'succeeded' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
      // Kullanıcı meta verisini sil
      public function destroy($id)
      {
          $userMeta = UserMeta::findOrFail($id);
          $userMeta->delete();
          return response()->json([
              'data' => null,
              'errors' => null,
              'messages' => 'User meta deleted successfully.',
              'succeeded' => true,
          ]);
      }
}
