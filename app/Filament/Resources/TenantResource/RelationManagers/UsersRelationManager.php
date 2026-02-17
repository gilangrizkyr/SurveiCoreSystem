<?php

namespace App\Filament\Resources\TenantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),
            Forms\Components\TextInput::make('email')
            ->email()
            ->required()
            ->maxLength(255),
            Forms\Components\Select::make('roles')
            ->multiple()
            ->options([
                'admin' => 'Administrator',
                'editor' => 'Editor',
                'viewer' => 'Viewer',
            ])
            ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
            Tables\Columns\TextColumn::make('name')
            ->label('Nama')
            ->searchable(),
            Tables\Columns\TextColumn::make('email')
            ->label('Email')
            ->searchable(),
            Tables\Columns\TextColumn::make('pivot.roles')
            ->label('Peran (Roles)')
            ->badge()
            ->separator(','),
        ])
            ->filters([
            //
        ])
            ->headerActions([
            Tables\Actions\AttachAction::make()
            ->form(fn(Tables\Actions\AttachAction $action): array => [
        $action->getRecordSelect(),
        Forms\Components\Select::make('roles')
        ->multiple()
        ->options([
        'admin' => 'Administrator',
        'editor' => 'Editor',
        'viewer' => 'Viewer',
        ])
        ->required(),
        ]),
        ])
            ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DetachAction::make(),
        ])
            ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DetachBulkAction::make(),
            ]),
        ]);
    }
}