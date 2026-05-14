<?php

namespace App\Contracts;

use App\DTO\SmsMessageData;

interface SmsProviderInterface
{
    public function send(SmsMessageData $data): array;
}