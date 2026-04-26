<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        $types = ['cash', 'bank', 'e-wallet', 'investment'];
        $type = fake()->randomElement($types);

        $names = match ($type) {
            'cash' => ['Cash on Hand', 'Petty Cash', 'Wallet'],
            'bank' => ['Bank Mandiri', 'SeaBank', 'BCA', 'BRI', 'BNI'],
            'e-wallet' => ['Dana', 'ShopeePay', 'GoPay', 'OVO', 'LinkAja'],
            'investment' => ['Mutual Fund', 'Stock Portfolio', 'Crypto Wallet'],
            default => ['Other Account'],
        };

        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement($names),
            'type' => $type,
            'currency' => 'IDR',
            'balance' => fake()->randomFloat(2, 100000, 50000000),
            'icon' => fake()->randomElement(['heroicon-o-wallet', 'heroicon-o-banknotes', 'heroicon-o-credit-card', 'heroicon-o-currency-dollar']),
            'description' => fake()->optional(0.5)->sentence(),
        ];
    }
}
