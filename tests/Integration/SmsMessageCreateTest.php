<?php

namespace Tests\Integration;

use App\Enums\SmsMessageStatus;
use App\Models\SmsMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmsMessageCreateTest extends TestCase
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

        SmsMessage::create($data);

        $this->assertDatabaseHas('sms_messages', [
            'id' => $data['id'],
            'to' => $data['to'],
            'message' => $data['message'],
            'status' => $data['status'],
            'provider' => $data['provider'],
            'external_id' => $data['external_id'],
        ]);
    }
}

