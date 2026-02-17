<?php

namespace App\Filament\Resources\DataRetentionPolicyResource\Pages;

use App\Filament\Resources\DataRetentionPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataRetentionPolicies extends ListRecords
{
    protected static string $resource = DataRetentionPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
