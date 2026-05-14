<?php

namespace App\DTO;

readonly class SmsProviderData
{
    public function __construct(
        public bool $success,
        public ?string $externalId,
    ) {
    }
}