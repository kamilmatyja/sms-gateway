<?php

namespace Tests\Integration;

use App\Models\SmsMessage;
use App\Models\SmsMessageStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmsMessageDatabaseTest extends TestCase
{
    use RefreshDatabase;

    final public function test_can_save_sms_message(): void
    {
        $data = [
            'id' => fake()->uuid(),
            'to' => fake()->phoneNumber(),
            'message' => 'Test message',
            'status' => SmsMessageStatus::Sent->value,
            'provider' => 'fakeSms',
            'external_id' => fake()->uuid(),
            'sent_at' => now(),
        ];

        $sms = SmsMessage::create($data);

        $this->assertDatabaseHas('sms_messages', [
            'id' => $data['id'],
            'to' => $data['to'],
            'message' => $data['message'],
            'status' => $data['status'],
            'provider' => $data['provider'],
            'external_id' => $data['external_id'],
        ]);
    }

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

