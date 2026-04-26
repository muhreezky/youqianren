<?php

namespace App\Filament\Resources\CurrencyResource;

use App\Filament\Resources\CurrencyResource\Pages;
use App\Models\Currency;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?int $navigationSort = 6;

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Currency Details')
                    ->components([
                        TextInput::make('code')
                            ->required()
                            ->maxLength(3)
                            ->unique(ignoreRecord: true)
                            ->placeholder('e.g., IDR')
                            ->uppercase(),
                        TextInput::make('symbol')
                            ->required()
                            ->maxLength(10)
                            ->placeholder('e.g., Rp'),
                        TextInput::make('exchange_rate')
                            ->required()
                            ->numeric()
                            ->minValue(0.000001)
                            ->step(0.000001)
                            ->helperText('Exchange rate relative to base currency'),
                        Toggle::make('is_custom')
                            ->label('Custom Currency')
                            ->helperText('Custom currencies are user-defined (e.g., crypto, local tokens)')
                            ->default(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('symbol')
                    ->searchable(),
                Tables\Columns\TextColumn::make('exchange_rate')
                    ->numeric(6)
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_custom')
                    ->label('Custom')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->placeholder('System')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_custom')
                    ->label('Custom Currency'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('code');
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
            'index' => Pages\ListCurrencies::route('/'),
            'create' => Pages\CreateCurrency::route('/create'),
            'edit' => Pages\EditCurrency::route('/{record}/edit'),
        ];
    }
}
