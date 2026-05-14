<?php

namespace App\Jobs;

use App\Contracts\SmsProviderInterface;
use App\DTO\SmsMessageData;
use App\Enums\SmsMessageStatus;
use App\Models\SmsMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class SendSmsJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $timeout = 30;

    public function __construct(
        public SmsMessage $sms
    ) {
    }

    final public function handle(
        SmsProviderInterface $provider
    ): void {
        try {
            $response = $provider->send(
                new SmsMessageData(
                    to: $this->sms->to,
                    message: $this->sms->message
                )
            );

            $this->sms->update([
                'status' => SmsMessageStatus::Sent,
                'sent_at' => $response->sentAt,
                'external_id' => $response->id,
            ]);
        } catch (Throwable $e) {
            $this->sms->update([
                'status' => SmsMessageStatus::Failed,
            ]);

            report($e);
        }
    }
}
