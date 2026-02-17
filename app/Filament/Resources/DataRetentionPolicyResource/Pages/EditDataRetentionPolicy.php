<?php

namespace App\Filament\Resources\DataRetentionPolicyResource\Pages;

use App\Filament\Resources\DataRetentionPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataRetentionPolicy extends EditRecord
{
    protected static string $resource = DataRetentionPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
