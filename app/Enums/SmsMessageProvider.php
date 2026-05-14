<?php

namespace App\Enums;

use App\Contracts\SmsProviderInterface;
use App\Services\Providers\SmsApiProvider;

enum SmsMessageProvider: string
{
    case FakeSms = 'fakeSms';
    case SmsApi = 'smsApi';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function fromInterface(SmsProviderInterface $provider): self
    {
        return match (get_class($provider)) {
            SmsApiProvider::class => self::SmsApi,
            default => self::FakeSms,
        };
    }
}

