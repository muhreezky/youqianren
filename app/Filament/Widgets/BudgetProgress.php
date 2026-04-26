<?php

namespace App\Filament\Widgets;

use App\Models\Budget;
use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class BudgetProgress extends TableWidget
{
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        $userId = auth()->id();

        return $table
            ->query(
                Budget::query()
                    ->where('user_id', $userId)
                    ->where('end_date', '>=', now())
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->placeholder('All')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->label('Budget')
                    ->sortable(),
                Tables\Columns\TextColumn::make('spent')
                    ->label('Spent')
                    ->getStateUsing(function (Budget $record): float {
                        $query = Transaction::where('user_id', $record->user_id)
                            ->where('type', 'expense')
                            ->whereBetween('date', [$record->start_date, $record->end_date]);

                        if ($record->category_id) {
                            $query->where('category_id', $record->category_id);
                        }

                        return $query->sum('amount');
                    })
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress')
                    ->getStateUsing(function (Budget $record): array {
                        $query = Transaction::where('user_id', $record->user_id)
                            ->where('type', 'expense')
                            ->whereBetween('date', [$record->start_date, $record->end_date]);

                        if ($record->category_id) {
                            $query->where('category_id', $record->category_id);
                        }

                        $spent = $query->sum('amount');
                        $percentage = $record->amount > 0 ? min(100, ($spent / $record->amount) * 100) : 0;

                        return [
                            'percentage' => round($percentage),
                            'spent' => $spent,
                        ];
                    })
                    ->formatStateUsing(function (array $state): HtmlString {
                        $percentage = $state['percentage'];
                        $color = $percentage >= 100 ? 'danger' : ($percentage >= 75 ? 'warning' : 'success');

                        return new HtmlString(
                            '<div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">' .
                            '<div class="bg-' . $color . '-500 h-2.5 rounded-full" style="width: ' . $percentage . '%"></div>' .
                            '</div>' .
                            '<span class="text-xs text-gray-500">' . $percentage . '% used</span>'
                        );
                    }),
            ])
            ->paginated(false)
            ->defaultSort('end_date');
    }
}
