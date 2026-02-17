<?php

namespace App\Filament\Resources\SurveyStatisticResource\Pages;

use App\Filament\Resources\SurveyStatisticResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurveyStatistics extends ListRecords
{
    protected static string $resource = SurveyStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
