<?php

namespace App\Filament\Resources\SurveyThemeResource\Pages;

use App\Filament\Resources\SurveyThemeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurveyThemes extends ListRecords
{
    protected static string $resource = SurveyThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
