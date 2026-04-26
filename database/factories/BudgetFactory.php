<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    protected $model = Budget::class;

    public function definition(): array
    {
        $period = fake()->randomElement(['daily', 'weekly', 'monthly', 'yearly']);
        $startDate = fake()->dateTimeBetween('-1 month', '+1 month');

        $endDate = match ($period) {
            'daily' => (clone $startDate)->modify('+1 day'),
            'weekly' => (clone $startDate)->modify('+7 days'),
            'monthly' => (clone $startDate)->modify('+1 month'),
            'yearly' => (clone $startDate)->modify('+1 year'),
        };

        return [
            'user_id' => User::factory(),
            'name' => fake()->sentence(3),
            'category_id' => Category::factory(),
            'amount' => fake()->randomFloat(2, 100000, 5000000),
            'currency' => 'IDR',
            'period' => $period,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'description' => fake()->optional(0.5)->sentence(),
        ];
    }
}
