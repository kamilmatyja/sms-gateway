<?php

namespace App\Services\Providers;

use App\Contracts\SmsProviderInterface;
use App\DTO\SmsMessageData;
use App\DTO\SmsProviderData;
use Exception;
use Illuminate\Support\Facades\Http;

class SmsApiProvider implements SmsProviderInterface
{
    /**
     * @throws Exception
     */
    final public function send(SmsMessageData $data): SmsProviderData
    {
        $response = Http::asForm()
            ->withToken(config('services.smsapi.token'))
            ->post('https://api.smsapi.pl/sms.do', [
                'to' => $data->to,
                'message' => $data->message,
                'from' => config('services.smsapi.from'),
                'format' => 'json',
            ]);

        if (!$response->successful()) {
            throw new Exception(
                'SMSAPI request failed'
            );
        }

        $json = $response->json();

        if (isset($json['error'])) {
            throw new Exception(
                $json['message'] ?? 'SMSAPI error'
            );
        }
    }
}