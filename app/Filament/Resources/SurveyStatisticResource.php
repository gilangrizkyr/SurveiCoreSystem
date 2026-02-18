<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyStatisticResource\Pages;
use App\Filament\Resources\SurveyStatisticResource\RelationManagers;
use App\Models\SurveyStatistic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurveyStatisticResource extends Resource
{
    protected static ?string $model = SurveyStatistic::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Analisis AI';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationLabel = 'Statistik Data';
    protected static ?string $modelLabel = 'Statistik';
    protected static ?string $pluralModelLabel = 'Pusat Statistik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('survey_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_views')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('total_started')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('total_completed')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('completion_rate')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('avg_completion_time')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\Textarea::make('drop_off_points')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('device_breakdown')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('location_breakdown')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('last_calculated_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('survey_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_views')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_started')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_completed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completion_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('avg_completion_time')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_calculated_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListSurveyStatistics::route('/'),
            'create' => Pages\CreateSurveyStatistic::route('/create'),
            'edit' => Pages\EditSurveyStatistic::route('/{record}/edit'),
        ];
    }
}