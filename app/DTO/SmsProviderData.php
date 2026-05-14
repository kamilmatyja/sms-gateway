<?php

namespace App\DTO;

use Carbon\CarbonInterface;

readonly class SmsProviderData
{
    public function __construct(
        public ?string $id,
        public ?CarbonInterface $sentAt
    ) {}
}
