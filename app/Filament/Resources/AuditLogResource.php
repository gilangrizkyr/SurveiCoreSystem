<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Filament\Resources\AuditLogResource\RelationManagers;
use App\Models\AuditLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = '6-KEAMANAN & LOG';
    protected static ?int $navigationSort = 15;
    protected static ?string $navigationLabel = 'Log Audit Aktivitas';
    protected static ?string $modelLabel = 'Log Audit';
    protected static ?string $pluralModelLabel = 'Riwayat Aktivitas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make('Detail Audit')
            ->schema([
                Forms\Components\TextInput::make('user.name')
                ->label('Pengguna'),
                Forms\Components\TextInput::make('action')
                ->label('Aksi'),
                Forms\Components\TextInput::make('model_type')
                ->label('Tipe Model'),
                Forms\Components\KeyValue::make('old_values')
                ->label('Nilai Lama'),
                Forms\Components\KeyValue::make('new_values')
                ->label('Nilai Baru'),
            ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('user.name')
            ->label('User')
            ->searchable(),
            Tables\Columns\TextColumn::make('action')
            ->label('Aksi')
            ->badge()
            ->color(fn(string $state): string => match ($state) {
            'create' => 'success',
            'update' => 'warning',
            'delete' => 'danger',
            default => 'gray',
        }),
            Tables\Columns\TextColumn::make('model_type')
            ->label('Model')
            ->searchable(),
            Tables\Columns\TextColumn::make('ip_address')
            ->label('IP Address'),
            Tables\Columns\TextColumn::make('created_at')
            ->label('Waktu')
            ->dateTime()
            ->sortable(),
        ])
            ->filters([
            Tables\Filters\SelectFilter::make('action')
            ->options([
                'created' => 'Baru (Created)',
                'updated' => 'Update',
                'deleted' => 'Hapus',
            ]),
        ])
            ->actions([
            Tables\Actions\ViewAction::make(),
        ])
            ->bulkActions([
            // Read-only usually
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
            'index' => Pages\ListAuditLogs::route('/'),
            'create' => Pages\CreateAuditLog::route('/create'),
            'edit' => Pages\EditAuditLog::route('/{record}/edit'),
        ];
    }
}