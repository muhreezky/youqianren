<?php

namespace App\Filament\Widgets;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Goal;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $userId = auth()->id();

        $totalBalance = Account::where('user_id', $userId)->sum('balance');
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');
        $activeGoals = Goal::where('user_id', $userId)
            ->where('current_amount', '<', \DB::raw('target_amount'))
            ->count();
        $activeBudgets = Budget::where('user_id', $userId)
            ->where('end_date', '>=', now())
            ->count();

        return [
            Stat::make('Total Balance', number_format($totalBalance, 0, ',', '.'))
                ->description('Across all accounts')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('primary'),
            Stat::make('Monthly Income', 'Rp ' . number_format($totalIncome, 0, ',', '.'))
                ->description('This month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Monthly Expenses', 'Rp ' . number_format($totalExpense, 0, ',', '.'))
                ->description('This month')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Active Goals', $activeGoals)
                ->description('In progress')
                ->descriptionIcon('heroicon-m-flag')
                ->color('warning'),
            Stat::make('Active Budgets', $activeBudgets)
                ->description('Currently tracking')
                ->descriptionIcon('heroicon-m-chart-pie')
                ->color('info'),
        ];
    }
}
