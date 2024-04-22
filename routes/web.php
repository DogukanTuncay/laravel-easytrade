<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});



// Tek bir rota için birden fazla middleware uygulama
Route::middleware(['auth', 'verified', 'checkAdmin'])->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');


    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'edit'])->name('edit');
        Route::patch('/', [UserController::class, 'update'])->name('update');
        Route::delete('/', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
    });
});

require __DIR__.'/auth.php';
