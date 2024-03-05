<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ContactFormController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Api\UserMetaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('auth/login', [LoginController::class, 'login']);
Route::post('auth/register', [LoginController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', function (Request $request) {
        return User::all();
    });

    Route::get('/user',[UserController::class,'index']);

    Route::prefix('/contact-forms')->group(function () {
            Route::get('/', [ContactFormController::class, 'index']);
            Route::post('/', [ContactFormController::class, 'store']);
            Route::get('/{id}', [ContactFormController::class, 'show']);
            Route::put('/{id}', [ContactFormController::class, 'update']);
            Route::delete('/{id}', [ContactFormController::class, 'destroy']);
    });

    Route::apiResource('user-metas', UserMetaController::class);


    // Route::get('/', [UserController::class, 'index']);

    // Route::get('profile', [UserController::class, 'index']);



});
