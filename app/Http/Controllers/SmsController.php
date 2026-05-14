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
use OpenApi\Annotations as OA;

class SmsController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/sms",
     *     summary="Wyślij SMS",
     *     tags={"SMS"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"to","message"},
     *             @OA\Property(property="to", type="string", example="+48123123123"),
     *             @OA\Property(property="message", type="string", example="Test message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utworzono SMS",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="string", example="uuid")
     *         )
     *     )
     * )
     */
    final public function send(
        SendSmsRequest $request,
        SmsSenderService $service
    ): JsonResponse {
        $message = $service->send(new SmsMessageData($request->to, $request->message));

        return ApiResponse::created($message->id);
    }

    /**
     * @OA\Get(
     *     path="/api/sms",
     *     summary="Pobierz listę SMS",
     *     tags={"SMS"},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="per_page", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Parameter(name="sort", in="query", required=false, @OA\Schema(type="string", example="sent_at:desc")),
     *     @OA\Parameter(name="status", in="query", required=false, @OA\Schema(type="string", example="sent")),
     *     @OA\Response(
     *         response=200,
     *         description="Lista SMS",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="to", type="string"),
     *                 @OA\Property(property="message", type="string"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="provider", type="string"),
     *                 @OA\Property(property="external_id", type="string"),
     *                 @OA\Property(property="sent_at", type="string", format="date-time"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="page", type="integer"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="last_page", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    final public function index(
        ListSmsRequest $request,
        SmsListService $service
    ): AnonymousResourceCollection
    {
        $messages = $service->list(
            new SmsListData($request->page, $request->perPage, $request->sort, $request->status)
        );

        return SmsResource::collection($messages);
    }
}
