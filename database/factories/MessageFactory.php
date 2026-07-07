<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
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
            'message_id' => strtoupper($this->faker->bothify('3EB0##########')),
            'chat_jid' => $this->faker->numerify('62896########').'@s.whatsapp.net',
            'sender_name' => $this->faker->name(),
            'body' => $this->faker->sentence(),
            'is_from_me' => false,
            'received_at' => $this->faker->dateTimeBetween('-1 week'),
        ];
    }
}
