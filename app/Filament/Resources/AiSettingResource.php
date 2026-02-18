<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AiSettingResource\Pages;
use App\Filament\Resources\AiSettingResource\RelationManagers;
use App\Models\AiSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AiSettingResource extends Resource
{
    protected static ?string $model = \App\Models\AiSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Analisis AI';
    protected static ?string $navigationLabel = 'Latih AI (Persona)';
    protected static ?string $modelLabel = 'Konfigurasi AI';
    protected static ?string $pluralModelLabel = 'Pusat Latihan AI';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Instruksi Karakter AI')
                    ->description('Tentukan bagaimana AI Anda harus berperilaku, berbicara, dan menjaga data.')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Kode Unik (Key)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabled(fn ($record) => $record !== null)
                            ->dehydrated()
                            ->placeholder('contoh: system_prompt'),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Pengaturan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'persona' => 'Identitas & Gaya Bahasa',
                                'security' => 'Keamanan & Privasi',
                            ])
                            ->required(),
                        \Filament\Forms\Components\MarkdownEditor::make('value')
                            ->label('Data / Instruksi Pelatihan')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Gunakan bahasa yang jelas dan instruksi yang spesifik untuk melatih AI.'),
                        Forms\Components\Textarea::make('description')
                            ->label('Catatan Internal')
                            ->columnSpanFull(),
                    ])->columns(['md' => 2]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('name')
            ->label('Tujuan Latihan')
            ->searchable(),
            Tables\Columns\TextColumn::make('category')
            ->label('Kategori')
            ->badge()
            ->color(fn(string $state): string => match ($state) {
            'persona' => 'success',
            'security' => 'danger',
            default => 'gray',
        }),
            Tables\Columns\TextColumn::make('description')
            ->label('Dampak')
            ->limit(50),
            Tables\Columns\TextColumn::make('updated_at')
            ->label('Latihan Terakhir')
            ->dateTime(),
        ])
            ->filters([
            //
        ])
            ->actions([
            Tables\Actions\EditAction::make()
            ->label('Update Latihan'),
        ])
            ->bulkActions([
            // Disabled for security
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAiSettings::route('/'),
        ];
    }
}