<?php

namespace App\Filament\Resources\SurveyResource\Widgets;

use Filament\Widgets\ChartWidget;

class SurveyStatsOverview extends ChartWidget
{
    protected static ?string $heading = 'Tren Respons (7 Hari Terakhir)';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        // Get data per day for last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d M');

            $count = \App\Models\SurveyResponse::whereDate('created_at', $date)->count();
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Respons Masuk',
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}