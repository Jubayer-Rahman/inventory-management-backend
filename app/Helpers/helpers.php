<?php

use Symfony\Component\HttpFoundation\Response;

if (! function_exists('apiSuccessResponse')) {
    function apiSuccessResponse(string $message, array $data = null, int $statusCode = Response::HTTP_OK)
    {
        $response = [
            'success' => true,
            'message' => $message
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }
}
