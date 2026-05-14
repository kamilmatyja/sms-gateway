<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function created(string $id): JsonResponse
    {
        return response()->json(['id' => $id], 201);
    }
}
