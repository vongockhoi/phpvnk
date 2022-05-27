<?php

namespace App\Helpers;

class ResponseHelper
{
    private static function response($message, $httpCode = 200)
    {
        return response()->json([
            'message' => $message
        ], $httpCode);
    }

    public static function success($data)
    {
        return response()->json($data);
    }

    public static function successful($message, $httpCode)
    {
        return self::response($message, $httpCode);
    }

    public static function failed($message, $httpCode = 401)
    {
        return self::response($message, $httpCode);
    }
}
