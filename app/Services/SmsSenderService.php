<?php

namespace App\Services;

use App\Contracts\SmsProviderInterface;
use App\DTO\SmsMessageData;
use App\Enums\SmsMessageProvider;
use App\Enums\SmsMessageStatus;
use App\Models\SmsMessage;
use App\Repositories\SmsMessageRepository;

readonly class SmsSenderService
{
    public function __construct(
        private SmsProviderInterface $provider,
        private SmsMessageRepository $repository,
    ) {
    }

    final public function send(SmsMessageData $dto): SmsMessage
    {
        $result = $this->provider->send($dto);

        return $this->repository->create(
            $dto->to,
            $dto->message,
            $result->success ? SmsMessageStatus::Sent->value : SmsMessageStatus::Failed->value,
            SmsMessageProvider::fromInterface($this->provider)->value,
            $result->externalId,
        );
    }
}