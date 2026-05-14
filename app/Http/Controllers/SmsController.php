<?php

namespace App\Http\Controllers;

use App\DTO\SmsListData;
use App\DTO\SmsMessageData;
use App\Http\Requests\ListSmsRequest;
use App\Http\Requests\SendSmsRequest;
use App\Http\Resources\SmsResource;
use App\Services\SmsListService;
use App\Services\SmsSenderService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'SMS',
    description: 'SMS management'
)]
class SmsController extends Controller
{
    #[OA\Post(
        path: '/api/sms',
        summary: 'Send SMS',
        requestBody: new OA\RequestBody(ref: '#/components/requestBodies/SendSmsRequestBody'),
        tags: ['SMS'],
        responses: [
            new OA\Response(ref: '#/components/responses/CreatedResponse', response: 201),
        ]
    )]
    final public function send(
        SendSmsRequest $request,
        SmsSenderService $service
    ): JsonResponse {
        $message = $service->send(
            new SmsMessageData($request->to, $request->message)
        );

        return ApiResponse::created($message->id);
    }

    #[OA\Get(
        path: '/api/sms',
        summary: 'List of SMS',
        tags: ['SMS'],
        parameters: [
            new OA\Parameter(ref: '#/components/parameters/ListSmsRequestParameters'),
        ],
        responses: [
            new OA\Response(ref: '#/components/responses/ListSmsResponse', response: 200),
        ]
    )]
    final public function index(
        ListSmsRequest $request,
        SmsListService $service
    ): AnonymousResourceCollection {
        $messages = $service->list(
            new SmsListData(
                $request->page,
                $request->perPage,
                $request->sort,
                $request->status
            )
        );

        return SmsResource::collection($messages);
    }
}
