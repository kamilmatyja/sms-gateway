<?php

namespace App\DTO;

readonly class SmsMessageData
{
    public function __construct(
        public string $to,
        public string $message,
    ) {
    }
}