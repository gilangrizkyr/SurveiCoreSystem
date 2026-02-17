<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyThemeResource\Pages;
use App\Filament\Resources\SurveyThemeResource\RelationManagers;
use App\Models\SurveyTheme;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurveyThemeResource extends Resource
{
    protected static ?string $model = SurveyTheme::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationGroup = '2-DESAIN & TEMPLATE';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Tema Visual';
    protected static ?string $modelLabel = 'Tema';
    protected static ?string $pluralModelLabel = 'Koleksi Tema';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tenant_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('primary_color')
                    ->required()
                    ->maxLength(255)
                    ->default('#000000'),
                Forms\Components\TextInput::make('secondary_color')
                    ->required()
                    ->maxLength(255)
                    ->default('#ffffff'),
                Forms\Components\TextInput::make('font_family')
                    ->required()
                    ->maxLength(255)
                    ->default('sans-serif'),
                Forms\Components\TextInput::make('logo_url')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\FileUpload::make('background_image')
                    ->image(),
                Forms\Components\Textarea::make('custom_css')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tenant_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('primary_color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('secondary_color')
                    ->searchable(),
                Tables\Columns\TextColumn::make('font_family')
                    ->searchable(),
                Tables\Columns\TextColumn::make('logo_url')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('background_image'),
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
            'index' => Pages\ListSurveyThemes::route('/'),
            'create' => Pages\CreateSurveyTheme::route('/create'),
            'edit' => Pages\EditSurveyTheme::route('/{record}/edit'),
        ];
    }
}