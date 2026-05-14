<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\RequestBody(
    request: 'SendSmsRequestBody',
    required: true,
    content: new OA\JsonContent(
        required: ['to', 'message'],
        properties: [
            new OA\Property(property: 'to', type: 'string'),
            new OA\Property(property: 'message', type: 'string'),
        ]
    )
)]
class SendSmsRequestBody {}
