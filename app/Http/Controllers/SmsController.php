<?php

namespace App\Http\Controllers;

use App\DTO\SmsListData;
use App\DTO\SmsMessageData;
use App\Http\Requests\ListSmsRequest;
use App\Http\Requests\SendSmsRequest;
use App\Http\Resources\SmsResourceCollection;
use App\Services\SmsListService;
use App\Services\SmsSenderService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class SmsController extends Controller
{
    final public function send(
        SendSmsRequest $request,
        SmsSenderService $service
    ): JsonResponse {
        $message = $service->send(new SmsMessageData($request->to, $request->message));

        return ApiResponse::created($message->id);
    }

    final public function index(
        ListSmsRequest $request,
        SmsListService $service
    ): SmsResourceCollection {
        $messages = $service->list(
            new SmsListData($request->page, $request->perPage, $request->sort, $request->status)
        );

        return new SmsResourceCollection($messages);
    }
}