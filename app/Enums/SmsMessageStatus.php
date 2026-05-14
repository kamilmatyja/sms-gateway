<?php

namespace App\Enums;

enum SmsMessageStatus: string
{
    case Sent = 'sent';
    case Failed = 'failed';
    case Queued = 'queued';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

