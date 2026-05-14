<?php

namespace App\Services\Providers;

use App\Contracts\SmsProviderInterface;
use App\DTO\SmsMessageData;
use App\DTO\SmsProviderData;
use Ramsey\Uuid\Uuid;

class SmsApiProvider implements SmsProviderInterface
{
    final public function send(SmsMessageData $data): SmsProviderData
    {
        return new SmsProviderData(true, Uuid::uuid4()->toString());
    }
}