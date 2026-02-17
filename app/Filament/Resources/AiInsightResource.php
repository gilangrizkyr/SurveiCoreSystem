<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AiInsightResource\Pages;
use App\Filament\Resources\AiInsightResource\RelationManagers;
use App\Models\AiInsight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AiInsightResource extends Resource
{
    protected static ?string $model = AiInsight::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';
    protected static ?string $navigationGroup = '4-ANALISIS & AI';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Insight AI';
    protected static ?string $modelLabel = 'Insight';
    protected static ?string $pluralModelLabel = 'Wawasan AI';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('survey_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('insight_type')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('data')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('confidence_score')
                    ->numeric()
                    ->default(null),
                Forms\Components\DateTimePicker::make('generated_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('survey_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('insight_type'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('confidence_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('generated_at')
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
            'index' => Pages\ListAiInsights::route('/'),
            'create' => Pages\CreateAiInsight::route('/create'),
            'edit' => Pages\EditAiInsight::route('/{record}/edit'),
        ];
    }
}