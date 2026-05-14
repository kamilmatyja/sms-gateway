<?php

namespace App\Services;

use App\Contracts\SmsProviderInterface;
use App\DTO\SmsMessageData;
use App\Enums\SmsMessageStatus;
use App\Models\SmsMessage;

readonly class SmsSenderService
{
    public function __construct(
        private SmsProviderInterface $provider
    ) {
    }

    final public function send(string $to, string $message): SmsMessage
    {
        $dto = new SmsMessageData($to, $message);

        $result = $this->provider->send($dto);

        return SmsMessage::create([
            'to' => $to,
            'message' => $message,
            'status' => $result['success'] ? SmsMessageStatus::Sent->value : SmsMessageStatus::Failed->value,
            'provider' => null,
            'external_id' => $result['external_id'],
            'sent_at' => now(),
        ]);
    }
}