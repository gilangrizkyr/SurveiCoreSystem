<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentResponses extends BaseWidget
{
    protected static ?string $heading = 'Aktivitas Responden Terbaru';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
            \App\Models\SurveyResponse::query()->latest()->limit(5)
        )
            ->columns([
            Tables\Columns\TextColumn::make('survey.title')
            ->label('Survei'),
            Tables\Columns\TextColumn::make('ip_address')
            ->label('Alamat IP'),
            Tables\Columns\TextColumn::make('status')
            ->badge()
            ->color(fn($state) => match ($state) {
            'completed' => 'success',
            'partial' => 'warning',
            default => 'gray',
        }),
            Tables\Columns\TextColumn::make('submitted_at')
            ->label('Waktu')
            ->dateTime()
            ->since(),
        ]);
    }
}