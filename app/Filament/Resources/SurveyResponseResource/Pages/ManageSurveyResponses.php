<?php

namespace App\Filament\Resources\SurveyResponseResource\Pages;

use App\Filament\Resources\SurveyResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSurveyResponses extends ManageRecords
{
    protected static string $resource = SurveyResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
