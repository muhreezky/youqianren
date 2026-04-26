<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['income', 'expense']);
        
        return [
            'user_id' => User::factory(),
            'account_id' => Account::factory(),
            'category_id' => Category::factory(),
            'type' => $type,
            'amount' => fake()->randomFloat(2, 5000, 5000000),
            'currency' => 'IDR',
            'date' => fake()->dateTimeBetween('-6 months', 'now'),
            'note' => fake()->optional(0.7)->sentence(),
        ];
    }
}
