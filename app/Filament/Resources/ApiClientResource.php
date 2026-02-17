<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiClientResource\Pages;
use App\Filament\Resources\ApiClientResource\RelationManagers;
use App\Models\ApiClient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiClientResource extends Resource
{
    protected static ?string $model = ApiClient::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static ?string $navigationGroup = '5-KONEKTIVITAS';
    protected static ?int $navigationSort = 12;
    protected static ?string $navigationLabel = 'Aplikasi Luar (Client)';
    protected static ?string $modelLabel = 'Client API';
    protected static ?string $pluralModelLabel = 'Koleksi Client';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Aplikasi')
                    ->schema([
                        Forms\Components\Hidden::make('uuid')
                            ->default((string) \Illuminate\Support\Str::uuid()),
                        
                        Forms\Components\Select::make('tenant_id')
                            ->relationship('tenant', 'name')
                            ->label('Instansi Pemilik')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Aplikasi / Klien')
                            ->placeholder('Contoh: Aplikasi Disdukcapil V2')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TagsInput::make('redirect_uris')
                            ->label('Redirect URIs (OAuth)')
                            ->placeholder('https://app.example.com/callback')
                            ->separator(',')
                            ->columnSpan(['default' => 'full']),
                    ])->columns(2),

                Forms\Components\Section::make('Kredensial API (Credentials)')
                    ->description('Rahasiakan Client Secret ini!.')
                    ->schema([
                        Forms\Components\TextInput::make('client_id')
                            ->label('Client ID')
                            ->default(fn () => \Illuminate\Support\Str::random(32))
                            ->readOnly()
                            ->required(),

                        Forms\Components\TextInput::make('client_secret')
                            ->label('Client Secret')
                            ->password()
                            ->revealable()
                            ->default(fn () => \Illuminate\Support\Str::random(64))
                            ->required()
                            ->helperText('Akan dienkripsi saat disimpan.'),
                    ])->columns(2),

                Forms\Components\Section::make('Status & Batasan')
                    ->schema([
                        /* Forms\Components\Select::make('tier')
                            ->label('Level Layanan')
                            ->options([
                                'enterprise' => 'Sistem Utama (Instansi)',
                            ])
                            ->default('enterprise')
                            ->required(), */
                        Forms\Components\Hidden::make('tier')
                            ->default('enterprise'),

                        Forms\Components\Select::make('status')
                            ->label('Status Kunci')
                            ->options([
                                'active' => 'Aktif',
                                'revoked' => 'Dicabut (Revoked)',
                                'suspended' => 'Dibekukan',
                            ])
                            ->default('active')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Aplikasi')
                    ->searchable()
                    ->sortable()
                    ->description(fn (ApiClient $record) => $record->tenant?->name),
                
                Tables\Columns\TextColumn::make('client_id')
                    ->label('Client ID')
                    ->copyable()
                    ->searchable()
                    ->fontFamily(\Filament\Support\Enums\FontFamily::Mono),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'active' => 'success',
                        'revoked' => 'danger',
                        'suspended' => 'warning',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListApiClients::route('/'),
            'create' => Pages\CreateApiClient::route('/create'),
            'edit' => Pages\EditApiClient::route('/{record}/edit'),
        ];
    }
}