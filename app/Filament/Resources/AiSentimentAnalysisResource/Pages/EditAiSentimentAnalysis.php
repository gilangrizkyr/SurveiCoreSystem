<?php

namespace App\Filament\Resources\AiSentimentAnalysisResource\Pages;

use App\Filament\Resources\AiSentimentAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAiSentimentAnalysis extends EditRecord
{
    protected static string $resource = AiSentimentAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
