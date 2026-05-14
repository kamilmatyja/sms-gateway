<?php

namespace App\Services;

use App\DTO\SmsListData;
use App\Repositories\SmsMessageRepository;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class SmsListService
{
    public function __construct(private SmsMessageRepository $repository) {}

    final public function list(SmsListData $dto): LengthAwarePaginator
    {
        return $this->repository->list($dto);
    }
}
