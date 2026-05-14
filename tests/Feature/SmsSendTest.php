<?php

namespace Tests\Feature;

use App\Contracts\SmsProviderInterface;
use App\DTO\SmsProviderData;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class SmsSendTest extends TestCase
{
    use RefreshDatabase;

    final public function test_send_success(): void
    {
        $this->mockSmsProvider();
        $payload = [
            'to' => '+48123123123',
            'message' => 'Test message',
        ];

        $response = $this->postJson('/api/sms', $payload);
        $response->assertCreated();
        $response->assertJsonStructure(['id']);
    }

    final public function test_send_empty_payload(): void
    {
        $response = $this->postJson('/api/sms', []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['to', 'message']);
    }

    final public function test_send_null_fields(): void
    {
        $payload = [
            'to' => null,
            'message' => null,
        ];
        $response = $this->postJson('/api/sms', $payload);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['to', 'message']);
    }

    final public function test_send_invalid_to(): void
    {
        $payload = [
            'to' => 'abc',
            'message' => 'Test message',
        ];
        $response = $this->postJson('/api/sms', $payload);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['to']);
    }

    final public function test_send_invalid_message(): void
    {
        $payload = [
            'to' => '+48123123123',
            'message' => '',
        ];
        $response = $this->postJson('/api/sms', $payload);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message']);
    }

    private function mockSmsProvider(): void
    {
        $mock = $this->createMock(SmsProviderInterface::class);
        $mock->method('send')->willReturn(new SmsProviderData(Uuid::uuid4()->toString(), new Carbon));
        $this->app->instance(SmsProviderInterface::class, $mock);
    }
}
