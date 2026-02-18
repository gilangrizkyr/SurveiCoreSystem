<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebhookResource\Pages;
use App\Filament\Resources\WebhookResource\RelationManagers;
use App\Models\Webhook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebhookResource extends Resource
{
    use \App\Traits\RestrictsToSuperAdmin;

    protected static ?string $model = Webhook::class;

    protected static ?string $navigationIcon = 'heroicon-o-rss';
    protected static ?string $navigationGroup = 'Integrasi API';
    protected static ?int $navigationSort = 14;
    protected static ?string $navigationLabel = 'Webhook (Otomasi)';

    protected static ?string $modelLabel = 'Webhook';

    protected static ?string $pluralModelLabel = 'Daftar Webhook';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make('Konfigurasi Webhook')
            ->schema([
                Forms\Components\TextInput::make('url')
                ->label('Target URL')
                ->url()
                ->required()
                ->placeholder('https://your-system.com/webhook')
                ->columnSpanFull(),

                Forms\Components\TextInput::make('secret')
                ->label('Secret Key (Signing)')
                ->default(fn() => \Illuminate\Support\Str::random(32))
                ->helperText('Gunakan kunci ini untuk memvalidasi kiriman dari sistem kami.'),

                Forms\Components\Select::make('events')
                ->label('Event yang Dipantau')
                ->multiple()
                ->options([
                    'survey.created' => 'Survei Baru Dibuat',
                    'response.submitted' => 'Jawaban Baru Masuk',
                    'survey.closed' => 'Survei Ditutup',
                ])
                ->required(),

                Forms\Components\Toggle::make('is_active')
                ->label('Aktifkan Webhook')
                ->default(true),
            ])->columns(['md' => 2]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('url')
            ->label('Target URL')
            ->searchable()
            ->limit(50),
            Tables\Columns\TextColumn::make('events')
            ->label('Events')
            ->badge(),
            Tables\Columns\IconColumn::make('is_active')
            ->label('Status')
            ->boolean(),
            Tables\Columns\TextColumn::make('created_at')
            ->label('Dibuat Pada')
            ->dateTime()
            ->sortable(),
        ])
            ->filters([
            Tables\Filters\TernaryFilter::make('is_active'),
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
            'index' => Pages\ListWebhooks::route('/'),
            'create' => Pages\CreateWebhook::route('/create'),
            'edit' => Pages\EditWebhook::route('/{record}/edit'),
        ];
    }
}