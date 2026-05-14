<?php

namespace App\Services\Providers;

use App\Contracts\SmsProviderInterface;
use App\DTO\SmsMessageData;
use App\DTO\SmsProviderData;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class FakeSmsProvider implements SmsProviderInterface
{
    final public function send(SmsMessageData $data): SmsProviderData
    {
        return new SmsProviderData(Uuid::uuid4()->toString(), new Carbon);
    }
}
