<?php

namespace App\Filament\Resources\SurveyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('title')
            ->label('Judul Bagian')
            ->placeholder('Contoh: Data Demografi')
            ->helperText('Bagi survei Anda menjadi beberapa bagian agar lebih mudah dipahami.')
            ->required()
            ->maxLength(255),
            Forms\Components\TextInput::make('order')
            ->label('Urutan')
            ->numeric()
            ->default(0)
            ->helperText('Angka urutan tampilan bagian ini.'),
            Forms\Components\Textarea::make('description')
            ->label('Deskripsi Bagian')
            ->placeholder('Contoh: Bagian ini berisi pertanyaan mengenai latar belakang responden.')
            ->columnSpanFull(),

            Forms\Components\Section::make('Daftar Pertanyaan')
            ->description('Tambahkan pertanyaan-pertanyaan yang ingin Anda ajukan di bagian ini.')
            ->schema([
                Forms\Components\Repeater::make('questions')
                ->label('Pertanyaan')
                ->relationship('questions')
                ->orderColumn('order')
                ->schema([
                    Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                        ->label('Teks Pertanyaan')
                        ->placeholder('Contoh: Apa alasan Anda menggunakan layanan kami?')
                        ->required(),
                        Forms\Components\Select::make('type')
                        ->label('Tipe Jawaban')
                        ->options([
                            'text' => 'Teks Pendek',
                            'textarea' => 'Teks Panjang',
                            'number' => 'Angka',
                            'select' => 'Pilihan Dropdown',
                            'checkbox' => 'Pilihan Ganda (Kotak Centang)',
                            'radio' => 'Pilihan Tunggal (Radio)',
                            'email' => 'Alamat Email',
                            'date' => 'Tanggal',
                            'nps' => 'Skor NPS (0-10)',
                            'rating' => 'Penilaian Bintang',
                        ])
                        ->required()
                        ->reactive()
                        ->helperText('Pilih format bagaimana responden harus menjawab.'),
                    ]),
                    Forms\Components\Textarea::make('description')
                    ->label('Petunjuk Tambahan')
                    ->placeholder('Contoh: Pilih satu jawaban yang paling mendekati.')
                    ->rows(2),
                    Forms\Components\Toggle::make('is_required')
                    ->label('Wajib Diisi?'),

                    Forms\Components\Repeater::make('options')
                    ->label('Pilihan Jawaban')
                    ->relationship('options')
                    ->orderColumn('order')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                        ->label('Label Tampilan')
                        ->placeholder('Contoh: Sangat Puas')
                        ->required(),
                        Forms\Components\TextInput::make('value')
                        ->label('Nilai Sistem')
                        ->placeholder('Contoh: sangat_puas')
                        ->required(),
                    ])
                    ->visible(fn($get) => in_array($get('type'), ['select', 'checkbox', 'radio']))
                    ->columns(2),
                ])
                ->columnSpanFull()
                ->collapsible()
                ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
            ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
            Tables\Columns\TextColumn::make('order')
            ->sortable(),
            Tables\Columns\TextColumn::make('title')
            ->searchable(),
        ])
            ->filters([
            //
        ])
            ->headerActions([
            Tables\Actions\CreateAction::make(),
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
}