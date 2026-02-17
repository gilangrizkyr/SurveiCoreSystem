<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyResource\Pages;
use App\Filament\Resources\SurveyResource\RelationManagers;
use App\Models\Survey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = '3-OPERASIONAL SURVEI';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Daftar Survei';
    protected static ?string $modelLabel = 'Survei';
    protected static ?string $pluralModelLabel = 'Unit Survei';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Detail Survei')
                        ->description('Informasi dasar mengenai survei')
                        ->icon('heroicon-m-clipboard-document-list')
                        ->schema([
                            Forms\Components\Hidden::make('uuid')
                                ->default((string) Str::uuid()),
                            
                            Forms\Components\TextInput::make('title')
                                ->label('Judul Survei')
                                ->placeholder('Contoh: Survei Kepuasan Masyarakat 2026')
                                ->helperText('Berikan judul yang jelas dan mudah dipahami oleh responden.')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),

                            Forms\Components\Grid::make(['default' => 2])
                                ->schema([
                                    Forms\Components\Select::make('type')
                                        ->label('Jenis Survei')
                                        ->options([
                                            'standard' => 'Standar (Kuesioner Umum)',
                                            'poll' => 'Poling (Satu Pertanyaan)',
                                            'quiz' => 'Kuis (Berskoring)',
                                        ])
                                        ->required()
                                        ->native(false)
                                        ->default('standard'),

                                    Forms\Components\Select::make('status')
                                        ->label('Status Publikasi')
                                        ->options([
                                            'draft' => 'Draf (Masih Konsep)',
                                            'active' => 'Aktif (Siap Diisi)',
                                            'paused' => 'Jeda (Sementara Tutup)',
                                            'closed' => 'Selesai (Ditutup Permanen)',
                                            'archived' => 'Arsip',
                                        ])
                                        ->required()
                                        ->native(false)
                                        ->default('draft'),
                                ]),

                            Forms\Components\Grid::make(['default' => 2])
                                ->schema([
                                    Forms\Components\Select::make('tenant_id')
                                        ->label('Instansi Pemilik')
                                        ->relationship('tenant', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->helperText('Pilih instansi yang menyelenggarakan survei ini.'),

                                    Forms\Components\Select::make('creator_id')
                                        ->label('Penanggung Jawab')
                                        ->relationship('creator', 'name')
                                        ->searchable()
                                        ->default(auth()->id())
                                        ->disabled()
                                        ->dehydrated(),
                                ]),

                            Forms\Components\Section::make('Konteks Penggunaan (Aplikasi)')
                                ->description('Informasi aplikasi luar yang menggunakan survei ini.')
                                ->schema([
                                    Forms\Components\TextInput::make('source_app_name')
                                        ->label('Nama Aplikasi / Website')
                                        ->placeholder('Contoh: Portal SiPinter')
                                        ->maxLength(255),
                                    
                                    Forms\Components\TextInput::make('source_app_url')
                                        ->label('Link Aplikasi (URL)')
                                        ->placeholder('https://sipinter.bandung.go.id')
                                        ->url()
                                        ->maxLength(255),

                                    Forms\Components\Textarea::make('usage_context')
                                        ->label('Tujuan / Cara Kelola')
                                        ->placeholder('Catatan: Digunakan untuk IKM bulanan, data ditarik via API ke Dashboard Utama...')
                                        ->rows(3),
                                ])->columns(['default' => 2]),
                        ]),

                    Forms\Components\Wizard\Step::make('Pesan & Konten')
                        ->description('Apa yang akan dilihat responden?')
                        ->icon('heroicon-m-chat-bubble-bottom-center-text')
                        ->schema([
                            Forms\Components\Textarea::make('description')
                                ->label('Deskripsi Singkat')
                                ->rows(3)
                                ->placeholder('Jelaskan tujuan survei ini secara singkat...')
                                ->columnSpanFull(),

                            Forms\Components\RichEditor::make('welcome_message')
                                ->label('Pesan Pembuka (Selamat Datang)')
                                ->toolbarButtons(['bold', 'italic', 'link', 'bulletList'])
                                ->placeholder('Selamat datang di survei kami...')
                                ->helperText('Pesan ini muncul di halaman awal sebelum responden mulai mengisi.'),

                            Forms\Components\RichEditor::make('thank_you_message')
                                ->label('Pesan Penutup (Terima Kasih)')
                                ->toolbarButtons(['bold', 'italic', 'link', 'bulletList'])
                                ->placeholder('Terima kasih atas partisipasi Anda...')
                                ->helperText('Pesan ini muncul setelah responden mengirim jawaban.'),
                        ]),

                    Forms\Components\Wizard\Step::make('Pengaturan Lanjutan')
                        ->description('Jadwal dan konfigurasi teknis')
                        ->icon('heroicon-m-cog-6-tooth')
                        ->schema([
                            Forms\Components\Fieldset::make('Jadwal Pelaksanaan')
                                ->schema([
                                    Forms\Components\DateTimePicker::make('starts_at')
                                        ->label('Mulai Otomatis')
                                        ->native(false)
                                        ->displayFormat('d M Y H:i'),
                                    
                                    Forms\Components\DateTimePicker::make('ends_at')
                                        ->label('Selesai Otomatis')
                                        ->native(false)
                                        ->displayFormat('d M Y H:i')
                                        ->helperText('Kosongkan jika survei berlaku selamanya.'),
                                ]),

                            Forms\Components\Section::make('Opsi Tambahan (Opsional)')
                                ->description('Bagian ini tidak wajib diisi. Digunakan untuk keperluan teknis.')
                                ->collapsed()
                                ->schema([
                                    Forms\Components\KeyValue::make('settings')
                                        ->label('Konfigurasi Sistem')
                                        ->helperText('Pengaturan teknis tambahan. Contoh: "enable_captcha": "true", "limit_response": "1".')
                                        ->keyLabel('Parameter')
                                        ->valueLabel('Nilai'),
                                        
                                    Forms\Components\KeyValue::make('metadata')
                                        ->label('Label / Tag Data')
                                        ->helperText('Label tambahan untuk laporan. Contoh: "divisi": "humas", "program": "smart_city".')
                                        ->keyLabel('Nama Label')
                                        ->valueLabel('Isi Label'),
                                ]),
                        ]),
                ])
                ->columnSpanFull()
                // ->skippable() // Optional: allow skipping steps
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Instansi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('source_app_name')
                    ->label('Aplikasi Sumber')
                    ->description(fn (Survey $record): ?string => $record->source_app_url)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draf',
                        'active' => 'Aktif',
                        'paused' => 'Berhenti',
                        'closed' => 'Tutup',
                        'archived' => 'Arsip',
                        default => $state,
                    })
                    ->color(fn (string $state) => match ($state) {
                        'draft' => 'gray',
                        'active' => 'success',
                        'paused' => 'warning',
                        'closed' => 'danger',
                        'archived' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe'),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Mulai')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('integration')
                    ->label('Integrasi API')
                    ->icon('heroicon-m-code-bracket')
                    ->color('info')
                    ->modalHeading('Panduan Integrasi API')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn ($action) => $action->label('Tutup'))
                    ->modalContent(fn ($record) => view('filament.resources.survey-resource.modals.integration', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
        ];
    }
}