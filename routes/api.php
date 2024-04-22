<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\UserController;
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
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});


Route::post('auth/login', [LoginController::class, 'login']);
Route::post('auth/register', [LoginController::class, 'register']);

Route::post('company/register', [CompanyController::class, 'register']);
Route::post('company/login', [CompanyController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::delete('/delete', [UserController::class, 'delete'])->name('user.delete');
        Route::get('/',[UserController::class,'index']);
        Route::post('/login-company',[UserController::class,'loginCompany']);
        Route::post('/logout-company',[UserController::class,'logoutCompany']);
    });
    // Route::get('profile', [UserController::class, 'index']);

    Route::middleware('checkCompany')->prefix('/company')->group(function () {
        // Tüm company işlemleri auth:sanctum ve checkCompany middleware'leri ile korunmalı

       // Route::get('/all', [CompanyController::class, 'index']); #TODO ADMİNE EKLENİCEK
        Route::get('/', [CompanyController::class, 'show']);
        Route::post('/active-users', [CompanyController::class, 'activeUsers']);
        Route::post('/inactive-users', [CompanyController::class, 'inactiveUsers']);
        Route::post('/change-status', [CompanyController::class, 'changeStatus']);
        Route::post('/user-logout', [CompanyController::class, 'userLogout']);
        Route::put('/', [CompanyController::class, 'update']);
        Route::delete('/', [CompanyController::class, 'destroy']);




        Route::prefix('/product')->group(function () {
            Route::get('/all', [ProductController::class, 'index']);
            Route::get('/{id}', [ProductController::class, 'show']);
            Route::post('/', [ProductController::class, 'store']);
            Route::put('/{id}', [ProductController::class, 'update']);
            Route::delete('/{id}', [ProductController::class, 'destroy']);
        });
    });
});
