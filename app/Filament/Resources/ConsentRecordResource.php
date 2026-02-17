<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsentRecordResource\Pages;
use App\Filament\Resources\ConsentRecordResource\RelationManagers;
use App\Models\ConsentRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsentRecordResource extends Resource
{
    protected static ?string $model = ConsentRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';
    protected static ?string $navigationGroup = '6-KEAMANAN & LOG';
    protected static ?int $navigationSort = 18;
    protected static ?string $navigationLabel = 'Persetujuan (Consent)';
    protected static ?string $modelLabel = 'Consent';
    protected static ?string $pluralModelLabel = 'Catatan Persetujuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('survey_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('response_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('consent_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('given')
                    ->required(),
                Forms\Components\TextInput::make('ip_address')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('user_agent')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('survey_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('response_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('consent_type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('given')
                    ->boolean(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_agent')
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
            'index' => Pages\ListConsentRecords::route('/'),
            'create' => Pages\CreateConsentRecord::route('/create'),
            'edit' => Pages\EditConsentRecord::route('/{record}/edit'),
        ];
    }
}