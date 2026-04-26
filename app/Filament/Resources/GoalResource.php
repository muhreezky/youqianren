<?php

namespace App\Filament\Resources\GoalResource;

use App\Filament\Resources\GoalResource\Pages;
use App\Models\Goal;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GoalResource extends Resource
{
    protected static ?string $model = Goal::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-flag';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Goal Details')
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Emergency Fund'),
                        FileUpload::make('image_path')
                            ->label('Goal Image')
                            ->image()
                            ->directory('goals')
                            ->visibility('private')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->helperText('Upload an image representing your goal'),
                        Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3),
                    ])->columns(2),
                Section::make('Target & Progress')
                    ->components([
                        TextInput::make('target_amount')
                            ->required()
                            ->numeric()
                            ->minValue(0.01)
                            ->prefix('Rp'),
                        TextInput::make('current_amount')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->prefix('Rp')
                            ->helperText('Current saved amount towards this goal'),
                        Select::make('currency')
                            ->label('Currency')
                            ->options(function () {
                                return \App\Models\Currency::pluck('code', 'code')->toArray();
                            })
                            ->default('IDR')
                            ->searchable(),
                    ])->columns(3),
                Section::make('Deadline')
                    ->components([
                        DatePicker::make('deadline')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->helperText('Target date to complete this goal'),
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
                Tables\Columns\TextColumn::make('current_amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress')
                    ->formatStateUsing(fn (float $state): string => number_format($state, 1) . '%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('deadline')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('isCompleted')
                    ->label('Completed')
                    ->boolean()
                    ->getStateUsing(fn (Goal $record): bool => $record->isCompleted())
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderByRaw(
                            "(current_amount / NULLIF(target_amount, 0)) * 100 >= 100 {$direction}"
                        );
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('deadline')
                    ->form([
                        DatePicker::make('deadline_from'),
                        DatePicker::make('deadline_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['deadline_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('deadline', '>=', $date),
                            )
                            ->when(
                                $data['deadline_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('deadline', '<=', $date),
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
            ->defaultSort('deadline');
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
            'index' => Pages\ListGoals::route('/'),
            'create' => Pages\CreateGoal::route('/create'),
            'edit' => Pages\EditGoal::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
