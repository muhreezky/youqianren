<?php

namespace App\Filament\Resources\AccountResource;

use App\Filament\Resources\AccountResource\Pages;
use App\Models\Account;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-wallet';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Account Details')
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., My Bank Account'),
                        Select::make('type')
                            ->required()
                            ->options([
                                'cash' => 'Cash',
                                'bank' => 'Bank',
                                'e-wallet' => 'E-Wallet',
                                'investment' => 'Investment',
                                'other' => 'Other',
                            ])
                            ->default('cash'),
                        TextInput::make('icon')
                            ->maxLength(255)
                            ->placeholder('heroicon-o-banknotes')
                            ->helperText('Heroicon name for the account icon'),
                    ])->columns(2),
                Section::make('Balance & Currency')
                    ->components([
                        TextInput::make('balance')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->prefix('Rp'),
                        Select::make('currency')
                            ->label('Currency')
                            ->options(fn () => \App\Models\Currency::pluck('code', 'code')->toArray())
                            ->default('IDR')
                            ->searchable(),
                        Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3),
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
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'cash' => 'success',
                        'bank' => 'primary',
                        'e-wallet' => 'info',
                        'investment' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('balance')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'cash' => 'Cash',
                        'bank' => 'Bank',
                        'e-wallet' => 'E-Wallet',
                        'investment' => 'Investment',
                        'other' => 'Other',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
