<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    protected function unauthenticated($request, AuthenticationException $exception)
{
    if ($request->expectsJson()) {
        // JSON bekleyen istekler için özelleştirilmiş hata mesajı
        return response()->json([
            'succeeded' => false, // Giriş başarısız
            'message' => 'The provided credentials are incorrect.',
            'errors' => null,
            'data' => null
        ], 401); // 401 Unauthorized, kimlik doğrulama hatası için kullanılır;
    }

    // Web istekleri için kullanıcıyı login sayfasına yönlendir
    return redirect()->guest(route('login'));
}
}
