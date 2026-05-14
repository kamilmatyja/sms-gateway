<?php

namespace App\DTO;

readonly class SmsListData
{
    private const int DEFAULT_PAGE = 1;
    private const int DEFAULT_PER_PAGE = 20;
    private const string DEFAULT_SORT = 'sent_at:asc';
    public int $page;
    public int $perPage;
    public string $sort;
    public ?string $status;

    public function __construct(
        ?int $page = null,
        ?int $perPage = null,
        ?string $sort = null,
        ?string $status = null,
    ) {
        $this->page = $page ?? self::DEFAULT_PAGE;
        $this->perPage = $perPage ?? self::DEFAULT_PER_PAGE;
        $this->sort = $sort ?? self::DEFAULT_SORT;
        $this->status = $status;
    }
}