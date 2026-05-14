<?php

namespace App\Repositories;

use App\Models\SmsMessage;
use Illuminate\Pagination\LengthAwarePaginator;

class SmsMessageRepository
{
    private const int DEFAULT_PER_PAGE = 15;

    final public function paginate(int $perPage = self::DEFAULT_PER_PAGE): LengthAwarePaginator
    {
        return SmsMessage::orderByDesc('created_at')->paginate($perPage);
    }
}

