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
    protected static ?string $navigationGroup = 'Analisis AI';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Analisis Sentimen';
    protected static ?string $modelLabel = 'Sentimen';
    protected static ?string $pluralModelLabel = 'Deteksi Sentimen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make('Analisis Sentimen BumbuAI')
            ->description('Analisis ini dilakukan secara profesional berdasarkan pola bahasa responden, dengan tetap menjaga privasi identitas.')
            ->schema([
                Forms\Components\Select::make('response_id')
                ->relationship('response', 'respondent_name')
                ->label('Responden')
                ->disabled(),
                Forms\Components\Select::make('question_id')
                ->relationship('question', 'title')
                ->label('Pertanyaan')
                ->disabled(),
                Forms\Components\Textarea::make('text_content')
                ->label('Jawaban Text')
                ->disabled()
                ->columnSpanFull(),
                Forms\Components\TextInput::make('sentiment')
                ->label('Sentimen')
                ->disabled(),
                Forms\Components\TextInput::make('confidence_score')
                ->label('Skor Keyakinan (0-1)')
                ->numeric()
                ->disabled(),
                Forms\Components\TextInput::make('emotion')
                ->label('Emosi Terdeteksi')
                ->disabled(),
                Forms\Components\DateTimePicker::make('processed_at')
                ->label('Waktu Analisis')
                ->disabled(),
            ])->columns(['md' => 2]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('response.respondent_name')
            ->label('Responden')
            ->searchable()
            ->placeholder('Anonymous'),
            Tables\Columns\TextColumn::make('question.title')
            ->label('Pertanyaan')
            ->searchable()
            ->limit(30),
            Tables\Columns\TextColumn::make('text_content')
            ->label('Jawaban')
            ->searchable()
            ->limit(50),
            Tables\Columns\TextColumn::make('sentiment')
            ->label('Sentimen')
            ->badge()
            ->color(fn(string $state): string => match ($state) {
            'positive' => 'success',
            'negative' => 'danger',
            'neutral' => 'gray',
            default => 'info',
        }),
            Tables\Columns\TextColumn::make('confidence_score')
            ->label('Akurasi')
            ->numeric(2)
            ->sortable(),
            Tables\Columns\TextColumn::make('emotion')
            ->label('Emosi'),
            Tables\Columns\TextColumn::make('processed_at')
            ->label('Dianalisis')
            ->dateTime()
            ->sortable(),
        ])
            ->filters([
            Tables\Filters\SelectFilter::make('sentiment')
            ->options([
                'positive' => 'Positif',
                'neutral' => 'Netral',
                'negative' => 'Negatif',
            ]),
        ])
            ->actions([
            Tables\Actions\ViewAction::make(),
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