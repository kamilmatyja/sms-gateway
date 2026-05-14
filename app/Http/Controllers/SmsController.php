<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendSmsRequest;
use App\Http\Resources\SmsResource;
use App\Services\SmsListService;
use App\Services\SmsSenderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SmsController extends Controller
{
    final public function send(
        SendSmsRequest $request,
        SmsSenderService $service
    ): JsonResponse {
        $message = $service->send(
            $request->to,
            $request->message
        );

        return response()->json([
            'success' => true,
            'data' => new SmsResource($message),
        ], 201);
    }

    final public function index(SmsListService $service): AnonymousResourceCollection
    {
        $messages = $service->getPaginated();

        return SmsResource::collection($messages);
    }
}