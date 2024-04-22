<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
class WhatsappService
{
    public static function refreshTokenIfNeeded()
    {
        if (!Session::has('whatsapp_integration_token')) {
            $client = new Client();
            $site = env('WP_SITE');
            try {
                $response = $client->request('POST', $site.'/admin/login', [
                    'headers' => [
                        'api' => env('WP_API_KEY'), // Özel key'inizi buraya ekleyin
                        // Diğer header'larınızı buraya ekleyebilirsiniz
                    ],
                    'form_params' => [
                        'email' => 'admin@easytrade.com',
                        'password' => 'admin',
                        // Diğer POST parametreleri
                    ],
                ]);
                dd($response);
                if ($response->getStatusCode() == 200) {
                $body = $response->getBody();
                $data = json_decode($body, true); // true parametresi ile bir array olarak dönüş sağlar
                // Token'ı JSON yanıttan çıkar
                $token = $data['data']['token']; // Yanıt yapınıza göre bu anahtarı ayarlayın
                dd($token);
                // Token'ı session'a kaydet
                Session::put('whatsapp_integration_token', $token);

                return $token; // Token'ı döndür veya başka bir işlem yap
            }
            } catch (GuzzleException $e) {

                throw new \Exception('Unable to login and obtain token.'.$e);
            }


        }

        return Session::get('whatsapp_integration_token');
    }
}
