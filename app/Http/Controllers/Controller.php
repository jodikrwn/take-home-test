<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

abstract class Controller
{
    protected function successResponse(mixed $data, string $message = '', int $status = 200): JsonResponse
    {
        $payload = ['data' => $data];
        if ($message !== '') {
            $payload['message'] = $message;
        }

        return response()->json($payload, $status);
    }

    protected function errorResponse(string $message, array $errors = [], int $status = 422): JsonResponse
    {
        $payload = ['message' => $message];
        if (!empty($errors)) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }

    protected function paginatedResponse(AnonymousResourceCollection $collection): JsonResponse
    {
        return $collection->response();
    }
}
