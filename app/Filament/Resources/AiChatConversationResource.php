<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AiChatConversationResource\Pages;
use App\Filament\Resources\AiChatConversationResource\RelationManagers;
use App\Models\AiChatConversation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AiChatConversationResource extends Resource
{
    protected static ?string $model = AiChatConversation::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationGroup = 'Analisis AI';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Tanya AI (Chat)';
    protected static ?string $modelLabel = 'Chat AI';
    protected static ?string $pluralModelLabel = 'Diskusi Data AI';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Diskusi dengan BumbuAI')
                    ->description('AI ini telah dilatih untuk bersikap profesional (Informative & Interactive) dan menjaga kerahasiaan data pribadi responden.')
                    ->schema([
                        Forms\Components\TextInput::make('session_id')
                            ->label('ID Sesi Chat')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\Textarea::make('message')
                            ->label('Pertanyaan / Perintah')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('response')
                            ->label('Jawaban BumbuAI')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Placeholder::make('security_note')
                            ->label('Peringatan Keamanan')
                            ->content('BumbuAI dilarang keras membocorkan Nama, Email, atau HP responden ke publik.')
                    ])->columns(['md' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tenant_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('session_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('intent')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiChatConversations::route('/'),
            'create' => Pages\CreateAiChatConversation::route('/create'),
            'edit' => Pages\EditAiChatConversation::route('/{record}/edit'),
        ];
    }
}