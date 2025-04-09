<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'professional_id' => User::factory(),
            'weekday' => $this->faker->numberBetween(0, 6), // 0 = Sunday, 6 = Saturday
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
        ];
    }
}
