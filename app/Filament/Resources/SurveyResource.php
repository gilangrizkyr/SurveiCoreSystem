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
    protected static ?string $navigationGroup = 'Manajemen Survei';
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
                                        ->label('Channel Akses')
                                        ->helperText('Pilih bagaimana survei ini akan diakses')
                                        ->helperText('Pilih bagaimana survei ini akan diakses. Publik (Web+API), Private (Internal), atau API Only.')
                                        ->options([
                                            'public' => '🌐 Publik (Web + API)',
                                            'private' => '🔒 Private (Internal Only)',
                                            'embedded' => '📦 Embedded (iFrame)',
                                            'api_only' => '🔌 API Only (Backend Only)',
                                        ])
                                        ->required()
                                        ->native(false)
                                        ->default('public'),

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
                                     Forms\Components\Select::make('creator_id')
                                         ->label('Penanggung Jawab')
                                         ->relationship('creator', 'name')
                                         ->searchable()
                                         ->default(auth()->id())
                                         ->disabled()
                                         ->dehydrated(),
                                 ]),

                            Forms\Components\Section::make('Link Survei Publik')
                                ->description('Bagikan link ini kepada masyarakat untuk mengisi survei.')
                                ->schema([
                                    Forms\Components\Placeholder::make('public_link_display')
                                        ->label('Link Survei')
                                        ->content(function ($record) {
                                            if (!$record) {
                                                return 'Link akan tersedia setelah survei dibuat';
                                            }
                                            $url = route('public.survey.show', ['uuid' => $record->uuid]);
                                            return new \Illuminate\Support\HtmlString(
                                                '<div class="flex items-center gap-2">
                                                    <code class="text-sm bg-gray-100 dark:bg-gray-800 px-3 py-2 rounded flex-1">' . e($url) . '</code>
                                                    <button type="button" 
                                                        onclick="navigator.clipboard.writeText(\'' . e($url) . '\').then(() => { 
                                                            new FilamentNotification().title(\'Link berhasil disalin!\').success().send(); 
                                                        })"
                                                        class="fi-btn fi-btn-size-md fi-color-gray fi-btn-color-gray">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </button>
                                                </div>'
                                            );
                                        }),
                                ])
                                ->visible(fn ($record) => $record !== null)
                                ->collapsible(),

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

                            Forms\Components\Section::make('Kontrol Responden & Duplikasi')
                                ->schema([
                                    Forms\Components\Toggle::make('require_respondent_identity')
                                        ->label('Wajib Isi Data Diri?')
                                        ->helperText('Jika aktif, responden wajib mengisi Nama & Email sebelum mulai.')
                                        ->default(false),
                                        
                                    Forms\Components\Toggle::make('allow_multiple_submissions')
                                        ->label('Izinkan Mengisi Berkali-kali?')
                                        ->helperText('Jika mati, satu orang hanya bisa mengisi satu kali.')
                                        ->default(true)
                                        ->reactive(),
                                        
                                    Forms\Components\Select::make('duplicate_prevention_method')
                                        ->label('Metode Pencegahan Duplikat')
                                        ->options([
                                            'cookie' => 'Browser Cookie (Simple)',
                                            'email' => 'Berdasarkan Email (Strict)',
                                            'login' => 'Wajib Login (Internal)',
                                        ])
                                        ->default('cookie')
                                        ->visible(fn (Forms\Get $get) => !$get('allow_multiple_submissions'))
                                        ->required(fn (Forms\Get $get) => !$get('allow_multiple_submissions')),
                                ])->columns(['md' => 2]),

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
                Tables\Columns\TextColumn::make('source_app_name')
                    ->label('Aplikasi Sumber')
                    ->description(fn (Survey $record): ?string => $record->source_app_url)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'draft' => 'Draf',
                        'active' => 'Aktif',
                        'paused' => 'Berhenti',
                        'closed' => 'Tutup',
                        'archived' => 'Arsip',
                        default => $state ?? 'Draft',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'success',
                        'paused' => 'warning',
                        'closed' => 'danger',
                        'archived' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('type')
                    ->label('Channel')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'public' => '🌐 Publik',
                        'api_only' => '🔌 API Only',
                        'embedded' => '📦 Embedded',
                        'private' => '🔒 Private',
                        default => ucfirst($state ?? 'public'),
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'public' => 'success',
                        'api_only' => 'info',
                        'embedded' => 'warning',
                        'private' => 'danger',
                        default => 'gray',
                    }),
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
                
                Tables\Actions\Action::make('preview')
                    ->label('Preview Survei')
                    ->icon('heroicon-m-eye')
                    ->color('success')
                    ->url(fn (Survey $record): string => route('public.survey.show', ['uuid' => $record->uuid]))
                    ->openUrlInNewTab()
                    ->tooltip('Lihat tampilan survei yang dilihat masyarakat'),
                
                Tables\Actions\Action::make('copy_link')
                    ->label('Salin Link')
                    ->icon('heroicon-m-clipboard-document')
                    ->color('gray')
                    ->requiresConfirmation(false)
                    ->action(function (Survey $record) {
                        $url = route('public.survey.show', ['uuid' => $record->uuid]);
                        
                        // Send notification with the URL
                        \Filament\Notifications\Notification::make()
                            ->title('Link Survei')
                            ->body($url)
                            ->success()
                            ->persistent()
                            ->actions([
                                \Filament\Notifications\Actions\Action::make('close')
                                    ->label('Tutup')
                                    ->close(),
                            ])
                            ->send();
                    })
                    ->modalHeading('Salin Link Survei')
                    ->modalDescription('Gunakan link ini untuk dibagikan ke responden.')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
                
                Tables\Actions\Action::make('export_csv')
                    ->label('Export CSV')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('success')
                    ->url(fn (Survey $record): string => route('admin.surveys.export_csv', $record->uuid))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('integration')
                    ->label('Integrasi API')
                    ->icon('heroicon-o-cpu-chip')
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
            RelationManagers\ResponsesRelationManager::class,
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