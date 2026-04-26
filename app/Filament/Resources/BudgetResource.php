<?php

namespace App\Filament\Resources\BudgetResource;

use App\Filament\Resources\BudgetResource\Pages;
use App\Models\Budget;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BudgetResource extends Resource
{
    protected static ?string $model = Budget::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Budget Details')
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Monthly Food Budget'),
                        Select::make('category_id')
                            ->label('Category (optional)')
                            ->options(function () {
                                $userId = auth()->id();
                                return \App\Models\Category::where(function ($q) use ($userId) {
                                    $q->where('user_id', $userId)
                                        ->orWhere('is_system', true);
                                })->pluck('name', 'id')->toArray();
                            })
                            ->nullable()
                            ->searchable()
                            ->preload()
                            ->helperText('Leave empty to apply to all categories'),
                        Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3),
                    ])->columns(2),
                Section::make('Amount & Period')
                    ->components([
                        TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->minValue(0.01)
                            ->prefix('Rp'),
                        Select::make('period')
                            ->required()
                            ->live()
                            ->options([
                                'daily' => 'Daily',
                                'weekly' => 'Weekly',
                                'monthly' => 'Monthly',
                                'yearly' => 'Yearly',
                            ])
                            ->default('monthly'),
                        Select::make('currency')
                            ->label('Currency')
                            ->options(function () {
                                return \App\Models\Currency::pluck('code', 'code')->toArray();
                            })
                            ->default('IDR')
                            ->searchable(),
                    ])->columns(3),
                Section::make('Date Range')
                    ->components([
                        DatePicker::make('start_date')
                            ->required()
                            ->default(now()->startOfMonth()),
                        DatePicker::make('end_date')
                            ->required()
                            ->default(now()->endOfMonth()),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('period')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('period')
                    ->options([
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('end_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBudgets::route('/'),
            'create' => Pages\CreateBudget::route('/create'),
            'edit' => Pages\EditBudget::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
