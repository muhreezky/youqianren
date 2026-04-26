<?php

namespace App\Filament\Resources\CategoryResource;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Details')
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Food & Drinks'),
                        TextInput::make('icon')
                            ->maxLength(255)
                            ->placeholder('heroicon-o-briefcase')
                            ->helperText('Heroicon name for the category icon'),
                        Toggle::make('is_system')
                            ->label('System Category')
                            ->helperText('System categories are predefined and visible to all users')
                            ->default(false),
                    ])->columns(2),
                Section::make('Parent Category')
                    ->components([
                        Select::make('parent_id')
                            ->label('Parent Category')
                            ->options(function () {
                                $userId = auth()->id();
                                return Category::where(function ($q) use ($userId) {
                                    $q->where('user_id', $userId)
                                        ->orWhere('is_system', true);
                                })
                                    ->whereNull('parent_id')
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->nullable()
                            ->searchable()
                            ->placeholder('No parent (top-level category)'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent')
                    ->placeholder('—')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_system')
                    ->label('System')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transactions_count')
                    ->label('Transactions')
                    ->counts('transactions')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_system')
                    ->label('System Category'),
                Tables\Filters\SelectFilter::make('parent')
                    ->relationship('parent', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where(function ($query) {
            $query->where('user_id', auth()->id())
                ->orWhere('is_system', true);
        });
    }
}
