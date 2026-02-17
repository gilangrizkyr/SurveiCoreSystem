<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AiSentimentAnalysisResource\Pages;
use App\Filament\Resources\AiSentimentAnalysisResource\RelationManagers;
use App\Models\AiSentimentAnalysis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AiSentimentAnalysisResource extends Resource
{
    protected static ?string $model = AiSentimentAnalysis::class;

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';
    protected static ?string $navigationGroup = '4-ANALISIS & AI';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Analisis Sentimen';
    protected static ?string $modelLabel = 'Sentimen';
    protected static ?string $pluralModelLabel = 'Deteksi Sentimen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('response_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('question_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('answer_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('text_content')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sentiment')
                    ->required(),
                Forms\Components\TextInput::make('confidence_score')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('emotion'),
                Forms\Components\DateTimePicker::make('processed_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('response_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('question_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('answer_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sentiment'),
                Tables\Columns\TextColumn::make('confidence_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('emotion'),
                Tables\Columns\TextColumn::make('processed_at')
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
            'index' => Pages\ListAiSentimentAnalyses::route('/'),
            'create' => Pages\CreateAiSentimentAnalysis::route('/create'),
            'edit' => Pages\EditAiSentimentAnalysis::route('/{record}/edit'),
        ];
    }
}