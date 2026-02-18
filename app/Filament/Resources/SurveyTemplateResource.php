<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyTemplateResource\Pages;
use App\Filament\Resources\SurveyTemplateResource\RelationManagers;
use App\Models\SurveyTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurveyTemplateResource extends Resource
{
    protected static ?string $model = SurveyTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Desain & Template';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Template Survei';
    protected static ?string $modelLabel = 'Template';
    protected static ?string $pluralModelLabel = 'Katalog Template';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make('Informasi Template')
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Nama Template')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('category')
                ->label('Kategori')
                ->placeholder('Contoh: Pendidikan, Kesehatan')
                ->required(),
                Forms\Components\Textarea::make('description')
                ->label('Deskripsi')
                ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Struktur Data (Blueprint)')
            ->schema([
                Forms\Components\KeyValue::make('structure')
                ->label('Struktur JSON Pertanyaan')
                ->helperText('Definisi JSON untuk bagian dan pertanyaan dalam template ini.')
                ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('name')
            ->label('Nama Template')
            ->searchable()
            ->sortable(),
            Tables\Columns\TextColumn::make('category')
            ->label('Kategori')
            ->badge()
            ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
            ->label('Dibuat Pada')
            ->dateTime()
            ->sortable(),
        ])
            ->filters([
            Tables\Filters\SelectFilter::make('category')
            ->options(fn() => \App\Models\SurveyTemplate::pluck('category', 'category')->toArray()),
        ])
            ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSurveyTemplates::route('/'),
            'create' => Pages\CreateSurveyTemplate::route('/create'),
            'edit' => Pages\EditSurveyTemplate::route('/{record}/edit'),
        ];
    }
}