<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\UserMetaController;
use App\Http\Controllers\WhatsappIntegrationController;
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








// Tek bir rota için birden fazla middleware uygulama
Route::middleware(['auth', 'verified', 'checkAdmin'])->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    // Profil işlemleri için rota grubu
    Route::get('/contact-forms', [ContactFormController::class, 'index'])->name('contactForms.index');
    Route::prefix('/profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('/metas')->name('metas.')->group(function () {
        Route::get('/', [UserMetaController::class, 'index'])->name('index');
        Route::patch('/', [UserMetaController::class, 'update'])->name('update');
        Route::delete('/', [UserMetaController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'edit'])->name('edit');
        Route::patch('/', [UserController::class, 'update'])->name('update');
        Route::delete('/', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
    });
    Route::get('/whatsapp', [WhatsappIntegrationController::class, 'index'])->name('whatsapp.index');
});

require __DIR__.'/auth.php';
