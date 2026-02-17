<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebhookLogResource\Pages;
use App\Filament\Resources\WebhookLogResource\RelationManagers;
use App\Models\WebhookLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebhookLogResource extends Resource
{
    protected static ?string $model = WebhookLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-command-line';
    protected static ?string $navigationGroup = '6-KEAMANAN & LOG';
    protected static ?int $navigationSort = 17;
    protected static ?string $navigationLabel = 'Log Webhook (Out)';
    protected static ?string $modelLabel = 'Log Webhook';
    protected static ?string $pluralModelLabel = 'Riwayat Webhook';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('webhook_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('event')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('payload')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status_code')
                    ->numeric()
                    ->default(null),
                Forms\Components\Textarea::make('response_body')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('attempt_number')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\DateTimePicker::make('delivered_at'),
                Forms\Components\DateTimePicker::make('failed_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('webhook_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attempt_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivered_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('failed_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListWebhookLogs::route('/'),
            'create' => Pages\CreateWebhookLog::route('/create'),
            'edit' => Pages\EditWebhookLog::route('/{record}/edit'),
        ];
    }
}