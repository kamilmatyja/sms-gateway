<?php

namespace Database\Factories;

use App\Enums\SmsMessageProvider;
use App\Enums\SmsMessageStatus;
use App\Models\SmsMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class SmsMessageFactory extends Factory
{
    protected $model = SmsMessage::class;

    final public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'to' => fake()->phoneNumber(),
            'message' => fake()->sentence(),
            'status' => fake()->randomElement(SmsMessageStatus::values()),
            'provider' => fake()->randomElement(SmsMessageProvider::values()),
            'external_id' => fake()->uuid(),
            'sent_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
