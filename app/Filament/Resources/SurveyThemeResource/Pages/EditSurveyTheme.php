<?php

namespace App\Filament\Resources\SurveyThemeResource\Pages;

use App\Filament\Resources\SurveyThemeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurveyTheme extends EditRecord
{
    protected static string $resource = SurveyThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
