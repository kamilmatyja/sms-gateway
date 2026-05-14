<?php

namespace App\Services;

use App\Contracts\SmsProviderInterface;
use App\DTO\SmsMessageData;
use App\Enums\SmsMessageProvider;
use App\Jobs\SendSmsJob;
use App\Models\SmsMessage;
use App\Repositories\SmsMessageRepository;

readonly class SmsSenderService
{
    public function __construct(
        private SmsProviderInterface $provider,
        private SmsMessageRepository $repository,
    ) {}

    final public function send(SmsMessageData $dto): SmsMessage
    {
        $message = $this->repository->create(
            $dto->to,
            $dto->message,
            SmsMessageProvider::fromInterface($this->provider)->value,
        );

        SendSmsJob::dispatch($message);

        return $message;
    }
}
