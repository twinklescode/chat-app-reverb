<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender_id' => rand(1,2),
            'receiver_id' => rand(1,2),
            'content' => fake()->text(),
            'delivery_status' => 'Pending',
            'read_status' => 'Unread',
            'message_type' => 'Text',
            'timestamp' => now(),
        ];
    }
}
