<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataRetentionPolicyResource\Pages;
use App\Filament\Resources\DataRetentionPolicyResource\RelationManagers;
use App\Models\DataRetentionPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataRetentionPolicyResource extends Resource
{
    protected static ?string $model = DataRetentionPolicy::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';
    protected static ?string $navigationGroup = '6-KEAMANAN & LOG';
    protected static ?int $navigationSort = 19;
    protected static ?string $navigationLabel = 'Kebijakan Data (Retention)';
    protected static ?string $modelLabel = 'Retention Policy';
    protected static ?string $pluralModelLabel = 'Aturan Penyimpanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tenant_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('data_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('retention_days')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('auto_delete')
                    ->required(),
                Forms\Components\DateTimePicker::make('last_cleanup_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tenant_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('retention_days')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('auto_delete')
                    ->boolean(),
                Tables\Columns\TextColumn::make('last_cleanup_at')
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
            'index' => Pages\ListDataRetentionPolicies::route('/'),
            'create' => Pages\CreateDataRetentionPolicy::route('/create'),
            'edit' => Pages\EditDataRetentionPolicy::route('/{record}/edit'),
        ];
    }
}