<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            ['code' => 'IDR', 'symbol' => 'Rp', 'is_custom' => false, 'exchange_rate' => 1.0],
            ['code' => 'USD', 'symbol' => '$', 'is_custom' => false, 'exchange_rate' => 0.000064],
            ['code' => 'EUR', 'symbol' => '€', 'is_custom' => false, 'exchange_rate' => 0.000059],
            ['code' => 'GBP', 'symbol' => '£', 'is_custom' => false, 'exchange_rate' => 0.000051],
            ['code' => 'JPY', 'symbol' => '¥', 'is_custom' => false, 'exchange_rate' => 0.0096],
            ['code' => 'SGD', 'symbol' => 'S$', 'is_custom' => false, 'exchange_rate' => 0.000086],
            ['code' => 'MYR', 'symbol' => 'RM', 'is_custom' => false, 'exchange_rate' => 0.00029],
            ['code' => 'CNY', 'symbol' => '¥', 'is_custom' => false, 'exchange_rate' => 0.00046],
            ['code' => 'KRW', 'symbol' => '₩', 'is_custom' => false, 'exchange_rate' => 0.086],
            ['code' => 'THB', 'symbol' => '฿', 'is_custom' => false, 'exchange_rate' => 0.0022],
            ['code' => 'AUD', 'symbol' => 'A$', 'is_custom' => false, 'exchange_rate' => 0.000099],
            ['code' => 'CAD', 'symbol' => 'C$', 'is_custom' => false, 'exchange_rate' => 0.000088],
            ['code' => 'CHF', 'symbol' => 'Fr', 'is_custom' => false, 'exchange_rate' => 0.000057],
            ['code' => 'HKD', 'symbol' => 'HK$', 'is_custom' => false, 'exchange_rate' => 0.00050],
            ['code' => 'INR', 'symbol' => '₹', 'is_custom' => false, 'exchange_rate' => 0.0054],
        ];

        foreach ($currencies as $currency) {
            Currency::firstOrCreate(
                ['code' => $currency['code']],
                $currency
            );
        }
    }
}
