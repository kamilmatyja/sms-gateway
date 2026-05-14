<?php

namespace App\Contracts;

use App\DTO\SmsMessageData;
use App\DTO\SmsProviderData;

interface SmsProviderInterface
{
    public function send(SmsMessageData $data): SmsProviderData;
}
