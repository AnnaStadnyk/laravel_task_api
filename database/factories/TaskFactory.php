<?php

namespace Database\Factories;

use App\Models\User;
use App\Priority;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Enum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->text(50),
            'description' => fake()->text(250),
            'is_comleted' => fake()->boolean(),
        ];
    }

    public function low()
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => Priority::Low->value,
            ];
        });
    }

    public function normal()
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => Priority::Normal->value,
            ];
        });
    }

    public function high()
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => Priority::High->value,
            ];
        });
    }

    public function controlAt()
    {
        return $this->state(function (array $attributes) {
            return [
                'control_at' => today()->addDays(rand(1, 10)),
            ];
        });
    }
}
