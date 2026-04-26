<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $names = ['Food', 'Transport', 'Shopping', 'Entertainment', 'Health', 'Education', 'Utilities', 'Salary', 'Freelance', 'Other'];

        return [
            'user_id' => User::factory(),
            'name' => fake()->unique()->randomElement($names) . ' ' . fake()->word(),
            'icon' => fake()->randomElement(['heroicon-o-briefcase', 'heroicon-o-banknotes', 'heroicon-o-shopping-bag', 'heroicon-o-heart']),
            'is_system' => false,
            'parent_id' => null,
        ];
    }
}
