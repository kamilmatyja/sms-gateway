<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'CreatedResponse',
    description: 'Created',
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: 'id', type: 'string'),
        ]
    )
)]
class CreatedResponse {}
