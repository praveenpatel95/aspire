<?php


namespace App\Helpers;


class JsonResponse
{
    static function success( $result = null, string $message = "Success"){
        return response()->json([
            "error" => false,
            "message" => $message,
            "result" => $result
        ]);
    }

    static function fail($message, int $errorCode = 200){
        return response()->json([
            "error" => true,
            "message" => $message,
        ], $errorCode);
    }
}
