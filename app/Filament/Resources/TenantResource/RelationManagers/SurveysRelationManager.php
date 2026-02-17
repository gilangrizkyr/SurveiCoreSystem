<?php

namespace App\Filament\Resources\TenantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurveysRelationManager extends RelationManager
{
    protected static string $relationship = 'surveys';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('title')
            ->label('Judul Survei')
            ->required()
            ->maxLength(255),
            Forms\Components\Select::make('status')
            ->options([
                'draft' => 'Draft',
                'active' => 'Aktif',
                'paused' => 'Ditunda',
                'closed' => 'Ditutup',
            ])
            ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
            Tables\Columns\TextColumn::make('title')
            ->label('Judul')
            ->searchable()
            ->limit(50),
            Tables\Columns\TextColumn::make('status')
            ->badge()
            ->color(fn(string $state): string => match ($state) {
            'active' => 'success',
            'draft' => 'gray',
            'paused' => 'warning',
            'closed' => 'danger',
            default => 'gray',
        }),
            Tables\Columns\TextColumn::make('responses_count')
            ->label('Jawaban')
            ->counts('responses')
            ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
            ->label('Dibuat')
            ->dateTime()
            ->since(),
        ])
            ->filters([
            Tables\Filters\SelectFilter::make('status'),
        ])
            ->headerActions([
            Tables\Actions\CreateAction::make(),
        ])
            ->actions([
            Tables\Actions\ViewAction::make()
            ->url(fn(\App\Models\Survey $record): string => \App\Filament\Resources\SurveyResource::getUrl('edit', ['record' => $record])),
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