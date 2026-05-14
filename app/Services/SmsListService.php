<?php

namespace App\Services;

use App\Repositories\SmsMessageRepository;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class SmsListService
{
    public function __construct(private SmsMessageRepository $repository)
    {
    }

    final public function getPaginated(): LengthAwarePaginator
    {
        return $this->repository->paginate();
    }
}

