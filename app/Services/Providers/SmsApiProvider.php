<?php

namespace App\Services\Providers;

use App\Contracts\SmsProviderInterface;
use App\DTO\SmsMessageData;
use App\DTO\SmsProviderData;
use Carbon\Carbon;
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
                'encoding' => 'utf-8',
            ]);

        $json = $response->json();
        $list = $json['list'][0] ?? [];

        if (isset($list['error'])) {
            throw new Exception($list['error']);
        }

        $id = $list['id'] ?? null;
        $dateSent = isset($list['date_sent']) ? new Carbon('@'.$list['date_sent']) : null;

        return new SmsProviderData($id, $dateSent);
    }
}
