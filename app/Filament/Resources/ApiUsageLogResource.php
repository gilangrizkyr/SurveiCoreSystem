<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiUsageLogResource\Pages;
use App\Filament\Resources\ApiUsageLogResource\RelationManagers;
use App\Models\ApiUsageLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiUsageLogResource extends Resource
{
    use \App\Traits\RestrictsToSuperAdmin;

    protected static ?string $model = ApiUsageLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Keamanan & Log';
    protected static ?int $navigationSort = 16;

    protected static ?string $navigationLabel = 'Log Penggunaan API';

    protected static ?string $modelLabel = 'Log API';

    protected static ?string $pluralModelLabel = 'Riwayat API';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make('Detail API Call')
            ->schema([
                Forms\Components\TextInput::make('client.name')
                ->label('Client'),
                Forms\Components\TextInput::make('endpoint')
                ->label('Endpoint'),
                Forms\Components\TextInput::make('status_code')
                ->label('HTTP Status'),
                Forms\Components\TextInput::make('response_time_ms')
                ->label('Response Time (ms)'),
                Forms\Components\KeyValue::make('request_payload')
                ->label('Request Data'),
            ])->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('client.name')
            ->label('Client')
            ->searchable(),
            Tables\Columns\TextColumn::make('endpoint')
            ->label('Endpoint')
            ->searchable(),
            Tables\Columns\TextColumn::make('status_code')
            ->label('Status')
            ->badge()
            ->color(fn(int $state): string => match (true) {
            $state >= 200 && $state < 300 => 'success',
            $state >= 400 && $state < 500 => 'warning',
            $state >= 500 => 'danger',
            default => 'gray',
        }),
            Tables\Columns\TextColumn::make('response_time_ms')
            ->label('Waktu (ms)')
            ->numeric()
            ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
            ->label('Waktu Panggil')
            ->dateTime()
            ->sortable(),
        ])
            ->filters([
            Tables\Filters\SelectFilter::make('status_code')
            ->options([
                '200' => '200 OK',
                '401' => '401 Unauthorized',
                '404' => '404 Not Found',
                '500' => '500 Server Error',
            ]),
        ])
            ->actions([
            Tables\Actions\ViewAction::make(),
        ])
            ->bulkActions([
            // Read-only
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
            'index' => Pages\ListApiUsageLogs::route('/'),
            'create' => Pages\CreateApiUsageLog::route('/create'),
            'edit' => Pages\EditApiUsageLog::route('/{record}/edit'),
        ];
    }
}