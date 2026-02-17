<?php

namespace App\Filament\Resources\TenantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiClientsRelationManager extends RelationManager
{
    protected static string $relationship = 'apiClients';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('name')
            ->label('Nama App/Client')
            ->required()
            ->maxLength(255),
            Forms\Components\Toggle::make('is_active')
            ->label('Aktif')
            ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
            Tables\Columns\TextColumn::make('name')
            ->label('Nama Client')
            ->searchable(),
            Tables\Columns\IconColumn::make('is_active')
            ->label('Status')
            ->boolean(),
            Tables\Columns\TextColumn::make('keys_count')
            ->label('Jumlah Key')
            ->counts('apiKeys'),
            Tables\Columns\TextColumn::make('created_at')
            ->label('Dibuat')
            ->dateTime()
            ->since(),
        ])
            ->filters([
            Tables\Filters\TernaryFilter::make('is_active'),
        ])
            ->headerActions([
            Tables\Actions\CreateAction::make(),
        ])
            ->actions([
            Tables\Actions\ViewAction::make()
            ->url(fn(\App\Models\ApiClient $record): string => \App\Filament\Resources\ApiClientResource::getUrl('edit', ['record' => $record])),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
            ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }
}