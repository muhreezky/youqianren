<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // System categories (will be assigned to user_id = 1 or null if global)
        // Since categories require user_id, we'll seed them per-user later.
        // For now, these are templates that get cloned on user creation.

        $categories = [
            // Income categories
            ['name' => 'Salary', 'icon' => 'heroicon-m-banknotes', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Freelance', 'icon' => 'heroicon-m-computer-desktop', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Investment', 'icon' => 'heroicon-m-chart-bar', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Gift', 'icon' => 'heroicon-m-gift', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Other Income', 'icon' => 'heroicon-m-plus', 'is_system' => true, 'parent_id' => null],

            // Expense categories
            ['name' => 'Food & Drinks', 'icon' => 'heroicon-m-restaurant', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Transportation', 'icon' => 'heroicon-m-truck', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Shopping', 'icon' => 'heroicon-m-shopping-bag', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Entertainment', 'icon' => 'heroicon-m-film', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Bills & Utilities', 'icon' => 'heroicon-m-receipt-percent', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Health', 'icon' => 'heroicon-m-heart', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Education', 'icon' => 'heroicon-m-academic-cap', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Housing', 'icon' => 'heroicon-m-home', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Insurance', 'icon' => 'heroicon-m-shield-check', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Savings', 'icon' => 'heroicon-m-piggy-bank', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Charity', 'icon' => 'heroicon-m-hand-heart', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Fuel', 'icon' => 'heroicon-m-fire', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Phone & Internet', 'icon' => 'heroicon-m-phone', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Clothing', 'icon' => 'heroicon-m-shirt', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Personal Care', 'icon' => 'heroicon-m-scissors', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Gifts & Donations', 'icon' => 'heroicon-m-gift', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Childcare', 'icon' => 'heroicon-m-queue-list', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Pet Care', 'icon' => 'heroicon-m-paw', 'is_system' => true, 'parent_id' => null],
            ['name' => 'Other Expense', 'icon' => 'heroicon-m-minus', 'is_system' => true, 'parent_id' => null],
        ];

        // Seed for user_id = 1 (first user) or as system templates
        // We'll use user_id 1 as default for system categories
        foreach ($categories as $category) {
            Category::firstOrCreate(
                [
                    'name' => $category['name'],
                    'user_id' => 1,
                ],
                $category
            );
        }
    }
}
