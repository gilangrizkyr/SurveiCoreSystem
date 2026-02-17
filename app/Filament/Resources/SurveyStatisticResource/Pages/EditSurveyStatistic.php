<?php

namespace App\Filament\Resources\SurveyStatisticResource\Pages;

use App\Filament\Resources\SurveyStatisticResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurveyStatistic extends EditRecord
{
    protected static string $resource = SurveyStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
