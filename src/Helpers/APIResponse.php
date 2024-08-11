<?php

namespace App\Helpers;


use Symfony\Component\HttpFoundation\JsonResponse;

class APIResponse
{



    public static function returnError( int $code = 400, string|array $message = "Something went wrong" ): JsonResponse
    {
        return new JsonResponse(
            data: [
                "message" => $message,
            ],
            status: $code
        );
    }

    public static function returnSuccess( int $code = 200, string|array $message = "" ): JsonResponse
    {
        return new JsonResponse(
            data: [
                "message" => $message,
            ],
            status: $code
        );
    }

}