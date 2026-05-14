<?php

namespace App\Repositories;

use App\DTO\SmsListData;
use App\Models\SmsMessage;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Uuid\Uuid;

class SmsMessageRepository
{
    final public function create(
        string $to,
        string $message,
        string $status,
        string $provider,
        ?string $externalId
    ): SmsMessage {
        return SmsMessage::create([
            'id' => Uuid::uuid4()->toString(),
            'to' => $to,
            'message' => $message,
            'status' => $status,
            'provider' => $provider,
            'external_id' => $externalId,
            'sent_at' => now(),
        ]);
    }

    final public function list(SmsListData $dto): LengthAwarePaginator
    {
        [$field, $direction] = explode(':', $dto->sort);

        return SmsMessage::query()
            ->when(
                $dto->status,
                fn($query) => $query->where(
                    'status',
                    $dto->status
                )
            )
            ->orderBy($field, $direction)
            ->paginate(
                perPage: $dto->perPage,
                page: $dto->page,
            );
    }
}

