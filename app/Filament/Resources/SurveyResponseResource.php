<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyResponseResource\Pages;
use App\Filament\Resources\SurveyResponseResource\RelationManagers;
use App\Models\SurveyResponse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class SurveyResponseResource extends Resource
{
    protected static ?string $model = SurveyResponse::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Manajemen Survei';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Hasil Jawaban';
    protected static ?string $modelLabel = 'Respon';
    protected static ?string $pluralModelLabel = 'Kumpulan Jawaban';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make('Informasi Responden')
            ->schema([
                Forms\Components\Select::make('survey_id')
                ->relationship('survey', 'title')
                ->disabled(),
                Forms\Components\TextInput::make('ip_address')
                ->label('Alamat IP')
                ->disabled(),
                Forms\Components\TextInput::make('device_type')
                ->label('Perangkat')
                ->disabled(),
                Forms\Components\DateTimePicker::make('submitted_at')
                ->label('Waktu Kirim')
                ->disabled(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('survey.title')
            ->label('Survei')
            ->searchable()
            ->sortable(),
            Tables\Columns\TextColumn::make('ip_address')
            ->label('Alamat IP')
            ->searchable(),
            Tables\Columns\TextColumn::make('status')
            ->label('Status')
            ->badge()
            ->color(fn(string $state): string => match ($state) {
            'completed' => 'success',
            'partial' => 'warning',
            'dropped' => 'danger',
            default => 'gray',
        }),
            Tables\Columns\TextColumn::make('completion_time_seconds')
            ->label('Durasi (detik)')
            ->numeric()
            ->sortable(),
            Tables\Columns\TextColumn::make('submitted_at')
            ->label('Waktu Kirim')
            ->dateTime()
            ->since()
            ->sortable(),
        ])
            ->filters([
            Tables\Filters\SelectFilter::make('survey')
            ->relationship('survey', 'title'),
        ])
            ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
            ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
            Infolists\Components\Section::make('Informasi Responden')
            ->schema([
                Infolists\Components\TextEntry::make('survey.title')
                ->label('Survei'),
                Infolists\Components\TextEntry::make('ip_address')
                ->label('Alamat IP'),
                Infolists\Components\TextEntry::make('device_type')
                ->label('Perangkat'),
                Infolists\Components\TextEntry::make('submitted_at')
                ->label('Waktu Selesai')
                ->dateTime(),
            ])->columns(2),

            Infolists\Components\Section::make('Daftar Jawaban')
            ->schema([
                Infolists\Components\RepeatableEntry::make('answers')
                ->label('Jawaban')
                ->schema([
                    Infolists\Components\TextEntry::make('question.title')
                    ->label('Pertanyaan')
                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                    Infolists\Components\TextEntry::make('answer_text')
                    ->label('Jawaban')
                    ->placeholder('Tidak ada jawaban teks')
                    ->visible(fn($record) => $record->answer_text !== null),
                    Infolists\Components\TextEntry::make('option.label')
                    ->label('Pilihan Terpilih')
                    ->visible(fn($record) => $record->option_id !== null),
                    Infolists\Components\TextEntry::make('answer_numeric')
                    ->label('Nilai Angka')
                    ->visible(fn($record) => $record->answer_numeric !== null),
                ])->columns(1),
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
            'index' => Pages\ListSurveyResponses::route('/'),
        ];
    }
}