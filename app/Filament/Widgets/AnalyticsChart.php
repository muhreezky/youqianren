<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;

class AnalyticsChart extends ChartWidget
{
    // protected static ?string $heading = 'Income vs Expenses';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public ?string $filter = '7d';

    protected function getFilters(): ?array
    {
        return [
            '7d' => 'Last 7 Days',
            '30d' => 'Last 30 Days',
            '3m' => 'Last 3 Months',
            '1y' => 'Last Year',
        ];
    }

    protected function getData(): array
    {
        $userId = auth()->id();
        $now = now();

        match ($this->filter) {
            '30d' => $startDate = $now->clone()->subDays(30),
            '3m' => $startDate = $now->clone()->subMonths(3),
            '1y' => $startDate = $now->clone()->subYear(),
            default => $startDate = $now->clone()->subDays(7),
        };

        $incomeData = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('date', [$startDate, $now])
            ->get()
            ->groupBy(fn ($t) => Carbon::parse($t->date)->format('Y-m-d'))
            ->map(fn ($group) => $group->sum('amount'));

        $expenseData = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('date', [$startDate, $now])
            ->get()
            ->groupBy(fn ($t) => Carbon::parse($t->date)->format('Y-m-d'))
            ->map(fn ($group) => $group->sum('amount'));

        // Generate all dates in range
        $labels = [];
        $current = $startDate->clone();
        while ($current <= $now) {
            $labels[] = $current->format('Y-m-d');
            $current->addDay();
        }

        $incomeValues = [];
        $expenseValues = [];
        foreach ($labels as $label) {
            $incomeValues[] = $incomeData->get($label, 0);
            $expenseValues[] = $expenseData->get($label, 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Income',
                    'data' => array_map('floatval', $incomeValues),
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Expenses',
                    'data' => array_map('floatval', $expenseValues),
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => array_map(function ($label) {
                return Carbon::parse($label)->format('M d');
            }, $labels),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
