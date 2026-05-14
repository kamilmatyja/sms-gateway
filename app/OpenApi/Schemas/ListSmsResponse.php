<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Response(
    response: 'ListSmsResponse',
    description: 'List of SMS',
    content: new OA\JsonContent(
        properties: [
            new OA\Property(
                property: 'data',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(property: 'id', type: 'string'),
                        new OA\Property(property: 'to', type: 'string'),
                        new OA\Property(property: 'message', type: 'string'),
                        new OA\Property(property: 'status', type: 'string'),
                        new OA\Property(property: 'provider', type: 'string'),
                        new OA\Property(property: 'externalId', type: 'string'),
                        new OA\Property(property: 'sentAt', type: 'string', format: 'date-time'),
                    ]
                )
            ),
            new OA\Property(
                property: 'links',
                properties: [
                    new OA\Property(property: 'first', type: 'string', format: 'uri'),
                    new OA\Property(property: 'last', type: 'string', format: 'uri'),
                    new OA\Property(property: 'prev', type: 'string', format: 'uri', nullable: true),
                    new OA\Property(property: 'next', type: 'string', format: 'uri', nullable: true),
                ],
                type: 'object'
            ),
            new OA\Property(
                property: 'meta',
                properties: [
                    new OA\Property(property: 'current_page', type: 'integer'),
                    new OA\Property(property: 'from', type: 'integer', nullable: true),
                    new OA\Property(property: 'last_page', type: 'integer'),
                    new OA\Property(
                        property: 'links',
                        type: 'array',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'url', type: 'string', format: 'uri', nullable: true),
                                new OA\Property(property: 'label', type: 'string'),
                                new OA\Property(property: 'page', type: 'integer', nullable: true),
                                new OA\Property(property: 'active', type: 'boolean'),
                            ],
                            type: 'object'
                        )
                    ),
                    new OA\Property(property: 'path', type: 'string', format: 'uri'),
                    new OA\Property(property: 'per_page', type: 'integer'),
                    new OA\Property(property: 'to', type: 'integer', nullable: true),
                    new OA\Property(property: 'total', type: 'integer'),
                ],
                type: 'object'
            ),
        ]
    )
)]
class ListSmsResponse {}
