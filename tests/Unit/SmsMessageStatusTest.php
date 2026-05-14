<?php

namespace Tests\Unit;

use App\Enums\SmsMessageStatus;
use PHPUnit\Framework\TestCase;

class SmsMessageStatusTest extends TestCase
{
    final public function test_values_returns_all_statuses(): void
    {
        $expected = ['sent', 'failed', 'queued'];
        $this->assertEqualsCanonicalizing($expected, SmsMessageStatus::values());
    }

    final public function test_enum_contains_specific_status(): void
    {
        $this->assertContains('sent', SmsMessageStatus::values());
        $this->assertContains('failed', SmsMessageStatus::values());
        $this->assertContains('queued', SmsMessageStatus::values());
    }
}
