<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Instansi', \App\Models\Tenant::count())
            ->description('Instansi yang terdaftar')
            ->descriptionIcon('heroicon-m-building-office')
            ->color('success'),
            Stat::make('Total Survei', \App\Models\Survey::count())
            ->description('Jumlah survei dibuat')
            ->descriptionIcon('heroicon-m-clipboard-document-list')
            ->color('info'),
            Stat::make('Total Jawaban Masuk', \App\Models\SurveyResponse::count())
            ->description('Data responden yang masuk')
            ->descriptionIcon('heroicon-m-chat-bubble-bottom-center-text')
            ->color('warning'),
        ];
    }
}