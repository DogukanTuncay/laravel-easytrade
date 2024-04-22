<?php

namespace App\Http\Responses;

trait ApiResponse
{
    /**
     * Başarılı yanıt döndürmek için kullanılır.
     *
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data = null, $message = '')
    {
        return response()->json([
            'data' => $data,
            'errors' => '',
            'messages' => $message,
            'succeeded' => true,
        ], 200);
    }

    /**
     * Hata yanıtı döndürmek için kullanılır.
     *
     * @param string $message
     * @param mixed $errors
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message = '', $errors = '', $status = 400)
    {
        return response()->json([
            'data' => null,
            'errors' => $errors,
            'messages' => $message,
            'succeeded' => false,
        ], $status);
    }
}
