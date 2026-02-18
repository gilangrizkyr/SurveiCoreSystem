<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiKeyResource\Pages;
use App\Filament\Resources\ApiKeyResource\RelationManagers;
use App\Models\ApiKey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiKeyResource extends Resource
{
    use \App\Traits\RestrictsToSuperAdmin;

    protected static ?string $model = ApiKey::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Integrasi API';
    protected static ?int $navigationSort = 13;
    protected static ?string $navigationLabel = 'Kunci Akses (Keys)';
    protected static ?string $modelLabel = 'API Key';
    protected static ?string $pluralModelLabel = 'Daftar API Key';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kunci API')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->relationship('client', 'name')
                            ->label('Aplikasi (Client)')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Kunci')
                            ->placeholder('Contoh: Kunci Produksi Server A')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('rate_limit')
                            ->label('Batas Rate Limit (RPM)')
                            ->numeric()
                            ->default(60)
                            ->required(),
                            
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Kadaluarsa Pada')
                            ->native(false),
                    ])->columns(['md' => 2]),

                Forms\Components\Section::make('Kredensial (Auto-Generated)')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('API Key (Public)')
                            ->default(fn () => 'sk_' . \Illuminate\Support\Str::random(32))
                            ->readOnly()
                            ->required(),
                            
                        Forms\Components\TextInput::make('secret')
                            ->label('Secret Key (Private)')
                            ->default(fn () => \Illuminate\Support\Str::random(64))
                            ->password()
                            ->revealable()
                            ->readOnly()
                            ->required()
                            ->helperText('Hanya bisa dilihat di sini. Simpan baik-baik.'),
                    ])->columns(['md' => 2]),

                Forms\Components\Section::make('Keamanan & Akses')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TagsInput::make('scopes')
                            ->label('Scopes (Izin Akses)')
                            ->placeholder('read_surveys, submit_responses')
                            ->separator(','),
                            
                        Forms\Components\TagsInput::make('ip_whitelist')
                            ->label('Whitelist IP Address')
                            ->placeholder('192.168.1.1')
                            ->helperText('Kosongkan untuk mengizinkan semua IP.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kunci')
                    ->searchable()
                    ->sortable()
                    ->description(fn (ApiKey $record) => $record->client?->name),
                
                Tables\Columns\TextColumn::make('key')
                    ->label('API Key')
                    ->copyable()
                    ->searchable()
                    ->fontFamily(\Filament\Support\Enums\FontFamily::Mono),

                Tables\Columns\TextColumn::make('rate_limit')
                    ->label('Limit (RPM)')
                    ->badge(),

                Tables\Columns\TextColumn::make('last_used_at')
                    ->label('Terakhir Dipakai')
                    ->since()
                    ->sortable(),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Kadaluarsa')
                    ->dateTime()
                    ->sortable()
                    ->color(fn ($state) => $state && $state < now() ? 'danger' : 'success'),

                Tables\Columns\IconColumn::make('revoked_at')
                    ->label('Status Kunci')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->revoked_at === null)
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
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
            'index' => Pages\ListApiKeys::route('/'),
            'create' => Pages\CreateApiKey::route('/create'),
            'edit' => Pages\EditApiKey::route('/{record}/edit'),
        ];
    }
}