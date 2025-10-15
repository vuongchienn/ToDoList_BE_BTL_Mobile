<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse
{
    const SUCCESS = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const CONFLICT = 409;
    const ERROR = 400;

    public static function success($data, $message, $statusCode = 200): JsonResponse
    {
        if ($data instanceof JsonResource) {

            return response()->json(
                $data->additional([
                    'message' => $message,
                    'status_code' => $statusCode
                ])->response()->getData(true),
                self::SUCCESS
            );
        }
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status_code' => $statusCode,
        ], self::SUCCESS);
    }

    public static function error($message, $statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status_code' => $statusCode
        ], self::SUCCESS);
    }
}
