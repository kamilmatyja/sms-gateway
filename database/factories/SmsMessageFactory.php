<?php

namespace Database\Factories;

use App\Enums\SmsMessageStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class SmsMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'to' => fake()->phoneNumber(),
            'message' => fake()->sentence(),
            'status' => fake()->randomElement(SmsMessageStatus::values()),
            'provider' => fake()->randomElement(['fakeSms', 'smsApi']),
            'external_id' => fake()->uuid(),
            'sent_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
