<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
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
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'duration_minutes' => $this->faker->numberBetween(15, 120),
        ];
    }
}
