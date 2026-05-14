<?php

namespace Tests\Feature;

use App\Enums\SmsMessageStatus;
use App\Models\SmsMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmsListTest extends TestCase
{
    use RefreshDatabase;

    final public function test_get_sms_success(): void
    {
        $this->seedSmsMessages();
        $response = $this->getJson('/api/sms');
        $response->assertOk();
        $response->assertJsonStructure(['data']);
        $this->assertGreaterThan(0, count($response->json('data')));
        $response->assertJsonStructure([
            'data',
            'meta' => ['page', 'per_page', 'last_page'],
        ]);
    }

    final public function test_get_sms_pagination(): void
    {
        $this->seedSmsMessages();
        $response = $this->getJson('/api/sms?perPage=2&page=2');
        $response->assertOk();
        $this->assertEquals(2, count($response->json('data')));
    }

    final public function test_get_sms_per_page_limits(): void
    {
        $this->seedSmsMessages();
        $response = $this->getJson('/api/sms?perPage=-1');
        $response->assertOk();
        $this->assertGreaterThan(0, count($response->json('data')));
        $response = $this->getJson('/api/sms?perPage=20');
        $response->assertOk();
        $this->assertLessThanOrEqual(15, count($response->json('data')));
    }

    final public function test_get_sms_sort_asc(): void
    {
        $this->seedSmsMessages();
        $response = $this->getJson('/api/sms?sort=sent_at:asc');
        $response->assertOk();
        $data = $response->json('data');
        $dates = array_column($data, 'sent_at');
        $sorted = $dates;
        sort($sorted);
        $this->assertEquals($sorted, $dates);
    }

    final public function test_get_sms_sort_desc(): void
    {
        $this->seedSmsMessages();
        $response = $this->getJson('/api/sms?sort=sent_at:desc');
        $response->assertOk();
        $data = $response->json('data');
        $dates = array_column($data, 'sent_at');
        $sorted = $dates;
        rsort($sorted);
        $this->assertEquals($sorted, $dates);
    }

    final public function test_get_sms_filter_status(): void
    {
        $this->seedSmsMessages();
        $response = $this->getJson('/api/sms?status=queued');
        $response->assertOk();
        foreach ($response->json('data') as $sms) {
            $this->assertEquals('queued', $sms['status']);
            $this->assertArrayHasKey('id', $sms);
            $this->assertArrayHasKey('to', $sms);
            $this->assertArrayHasKey('message', $sms);
            $this->assertArrayHasKey('status', $sms);
            $this->assertArrayHasKey('provider', $sms);
            $this->assertArrayHasKey('external_id', $sms);
            $this->assertArrayHasKey('sent_at', $sms);
        }
    }

    final public function test_get_sms_invalid_data(): void
    {
        $this->seedSmsMessages();
        $response = $this->getJson('/api/sms?sort=invalid');
        $response->assertStatus(422);
        $response = $this->getJson('/api/sms?perPage=abc');
        $response->assertStatus(422);
        $response = $this->getJson('/api/sms?status=notastatus');
        $response->assertStatus(422);
    }

    private function seedSmsMessages(): void
    {
        SmsMessage::factory()->count(10)->create(['status' => SmsMessageStatus::Sent->value]);
        SmsMessage::factory()->count(5)->create(['status' => SmsMessageStatus::Queued->value]);
    }
}
