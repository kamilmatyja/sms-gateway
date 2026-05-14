<?php

namespace Tests\Integration;

use App\Enums\SmsMessageStatus;
use App\Models\SmsMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmsMessageReadTest extends TestCase
{
    use RefreshDatabase;

    final public function test_can_read_sms_message(): void
    {
        $sms = SmsMessage::factory()->create([
            'message' => 'Read test',
            'status' => SmsMessageStatus::Queued->value,
        ]);

        $found = SmsMessage::find($sms->id);

        $this->assertNotNull($found);
        $this->assertEquals('Read test', $found->message);
        $this->assertEquals(SmsMessageStatus::Queued->value, $found->status);
    }
}

