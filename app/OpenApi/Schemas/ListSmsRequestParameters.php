<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Parameter(
    parameter: 'ListSmsRequestParameters',
    name: 'ListSmsRequestParameters',
    description: 'Parameters for listing SMS',
    in: 'query',
    required: false,
    schema: new OA\Schema(
        properties: [
            new OA\Property(property: 'page', type: 'integer', example: 1),
            new OA\Property(property: 'perPage', type: 'integer', example: 10),
            new OA\Property(property: 'sort', type: 'string', example: 'sent_at:desc'),
            new OA\Property(property: 'status', type: 'string', example: 'sent'),
        ],
        type: 'object'
    )
)]
class ListSmsRequestParameters {}
