<?php

namespace App\Filament\Resources\AiChatConversationResource\Pages;

use App\Filament\Resources\AiChatConversationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAiChatConversation extends EditRecord
{
    protected static string $resource = AiChatConversationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
