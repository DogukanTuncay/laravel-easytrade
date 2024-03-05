<?php

namespace App\Http\Controllers;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
class WhatsAppIntegrationController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsappService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }
    public function index() {
        // Token'ı kontrol edip gerekiyorsa yenile
        $this->whatsAppService->refreshTokenIfNeeded();
        dd(session()->all());
        // Token yenilendi veya zaten mevcutsa, WhatsApp sayfasını göster
        return view('backend.whatsapp.index',);

    }
}
