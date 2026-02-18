<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\ApiClient;

class DashboardStats extends BaseWidget
{
    protected static ?int $sort = -1; // Below welcome banner

    protected function getStats(): array
    {
        return [
            Stat::make('Survei Aktif', Survey::where('status', 'active')->count())
            ->description('Survei yang sedang berjalan')
            ->descriptionIcon('heroicon-m-clipboard-document-check')
            ->color('success')
            ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Total Jawaban Masuk', SurveyResponse::count())
            ->description('Dari seluruh survei')
            ->descriptionIcon('heroicon-m-users')
            ->color('info')
            ->chart([15, 4, 10, 2, 12, 4, 12]),

            Stat::make('Aplikasi Terhubung', ApiClient::where('status', 'active')->count())
            ->description('Sistem eksternal yang aktif')
            ->descriptionIcon('heroicon-m-server-stack')
            ->color('warning'),
        ];
    }
}