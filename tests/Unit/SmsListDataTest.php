<?php

namespace Tests\Unit;

use App\DTO\SmsListData;
use PHPUnit\Framework\TestCase;

class SmsListDataTest extends TestCase
{
    final public function test_defaults(): void
    {
        $dto = new SmsListData();
        $this->assertEquals(1, $dto->page);
        $this->assertEquals(20, $dto->perPage);
        $this->assertEquals('sent_at:asc', $dto->sort);
        $this->assertNull($dto->status);
    }

    final public function test_custom_values(): void
    {
        $dto = new SmsListData(page: 2, perPage: 50, sort: 'sent_at:desc', status: 'sent');
        $this->assertEquals(2, $dto->page);
        $this->assertEquals(50, $dto->perPage);
        $this->assertEquals('sent_at:desc', $dto->sort);
        $this->assertEquals('sent', $dto->status);
    }
}

