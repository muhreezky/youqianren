<?php

namespace Database\Factories;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goal>
 */
class GoalFactory extends Factory
{
    protected $model = Goal::class;

    public function definition(): array
    {
        $targetAmount = fake()->randomFloat(2, 1000000, 100000000);

        return [
            'user_id' => User::factory(),
            'name' => fake()->sentence(3),
            'target_amount' => $targetAmount,
            'currency' => 'IDR',
            'deadline' => fake()->dateTimeBetween('+1 month', '+2 years'),
            'current_amount' => fake()->randomFloat(2, 0, $targetAmount),
            'description' => fake()->optional(0.7)->sentence(),
        ];
    }
}
