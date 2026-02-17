<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TenantResource\Pages;
use App\Filament\Resources\TenantResource\RelationManagers;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = '1. Konfigurasi Instansi';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Manajemen Instansi';
    protected static ?string $modelLabel = 'Instansi';
    protected static ?string $pluralModelLabel = 'Daftar Instansi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(['default' => 2])
                    ->schema([
                        Forms\Components\Section::make('Identitas Instansi')
                            ->description('Informasi dasar mengenai organisasi.')
                            ->columnSpan(['default' => 2])
                            ->schema([
                                Forms\Components\Hidden::make('uuid')
                                    ->default((string) \Illuminate\Support\Str::uuid()),
                                
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Instansi')
                                    ->placeholder('Contoh: DPMPTSP Kota Bandung')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->placeholder('dpmptsp-kota-bandung')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Akan digunakan sebagai identitas URL unik.'),

                                Forms\Components\TextInput::make('domain')
                                    ->label('Domain Kustom (Opsional)')
                                    ->placeholder('survei.bandung.go.id')
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Jika instansi menggunakan domain sendiri.'),
                            ])->columns(2),

                        Forms\Components\Section::make('Status & Layanan')
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status Akun')
                                    ->options([
                                        'active' => 'Aktif (Active)',
                                        'suspended' => 'Dibekukan (Suspended)',
                                    ])
                                    ->required()
                                    ->default('active')
                                    ->native(false),
                            ]),
                    ]),

                Forms\Components\Section::make('Konfigurasi Lanjutan')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('database')
                            ->label('Database Khusus (Tenancy)')
                            ->placeholder('tenant_dpmptsp')
                            ->helperText('Hanya diisi jika menggunakan database terpisah.'),

                        Forms\Components\KeyValue::make('settings')
                            ->label('Pengaturan JSON')
                            ->keyLabel('Kunci')
                            ->valueLabel('Nilai'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Instansi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('domain')
                    ->label('Domain')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'suspended' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
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
            RelationManagers\UsersRelationManager::class,
            RelationManagers\SurveysRelationManager::class,
            RelationManagers\ApiClientsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}