<?php

namespace App\Filament\Resources\TransactionResource;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Account;
use App\Models\Transaction;
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

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-left-right';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Transaction Details')
                    ->components([
                        DatePicker::make('date')
                            ->required()
                            ->default(now()),
                        Select::make('type')
                            ->required()
                            ->live()
                            ->options([
                                'income' => 'Income',
                                'expense' => 'Expense',
                                'transfer' => 'Transfer',
                            ])
                            ->default('expense'),
                        Select::make('account_id')
                            ->label('From Account')
                            ->required()
                            ->options(fn () => Account::where('user_id', auth()->id())->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->preload(),
                        Select::make('to_account_id')
                            ->label('To Account')
                            ->required(fn (callable $get): bool => $get('type') === 'transfer')
                            ->hidden(fn (callable $get): bool => $get('type') !== 'transfer')
                            ->options(fn () => Account::where('user_id', auth()->id())->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->preload()
                            ->helperText('Required for transfer transactions'),
                    ])->columns(2),
                Section::make('Amount & Category')
                    ->components([
                        TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->minValue(0.01)
                            ->prefix('Rp'),
                        Select::make('category_id')
                            ->label('Category')
                            ->required()
                            ->options(function () {
                                $userId = auth()->id();
                                return \App\Models\Category::where(function ($q) use ($userId) {
                                    $q->where('user_id', $userId)
                                        ->orWhere('is_system', true);
                                })->pluck('name', 'id')->toArray();
                            })
                            ->searchable()
                            ->preload(),
                        Select::make('currency')
                            ->label('Currency')
                            ->options(function () {
                                return \App\Models\Currency::pluck('code', 'code')->toArray();
                            })
                            ->default('IDR')
                            ->searchable(),
                    ])->columns(3),
                Section::make('Additional Info')
                    ->components([
                        Textarea::make('note')
                            ->columnSpanFull()
                            ->rows(3)
                            ->placeholder('Add a note for this transaction...'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'income' => 'success',
                        'expense' => 'danger',
                        'transfer' => 'info',
                    }),
                Tables\Columns\TextColumn::make('account.name')
                    ->label('Account')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('note')
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'income' => 'Income',
                        'expense' => 'Expense',
                        'transfer' => 'Transfer',
                    ]),
                Tables\Filters\SelectFilter::make('account')
                    ->relationship('account', 'name'),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\Filter::make('date')
                    ->form([
                        DatePicker::make('date_from'),
                        DatePicker::make('date_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
