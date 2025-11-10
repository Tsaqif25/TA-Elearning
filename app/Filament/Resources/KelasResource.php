<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?string $navigationLabel = 'Kelas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Kelas')
                ->placeholder('Contoh: XII TKJ 1')
                ->required()
                ->unique(ignoreRecord: true),

            // Forms\Components\TextInput::make('jurusan')
            //     ->label('Jurusan')
            //     ->placeholder('Contoh: PPLG, TKJ, AKL, dsb.')
            //     ->nullable(),

            Forms\Components\Select::make('mapels')
                ->label('Mata Pelajaran')
                ->relationship('mapels', 'name')
                ->multiple()
                ->preload()
                ->helperText('Pilih satu atau lebih mapel yang diampu di kelas ini.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Kelas')->searchable()->sortable(),
                // Tables\Columns\TextColumn::make('jurusan')->label('Jurusan')->sortable(),
                Tables\Columns\BadgeColumn::make('mapels_count')->counts('mapels')->label('Jumlah Mapel'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->date('d M Y'),
            ])
            // ->filters([
            //     Tables\Filters\SelectFilter::make('jurusan')
            //         ->label('Filter Jurusan')
            //         ->options([
            //             'TKJ' => 'Teknik Komputer & Jaringan (TKJ)',
            //             'PPLG' => 'Pengembangan Perangkat Lunak & Gim (PPLG)',
            //             'MPLB' => 'Manajemen Perkantoran & Layanan Bisnis (MPLB)',
            //             'ULW' => 'Usaha Layanan Wisata (ULW)',
            //             'BR'  => 'Bisnis Ritel (BR)',
            //             'BD'  => 'Bisnis Digital (BD)',
            //             'AKL' => 'Akuntansi & Keuangan Lembaga (AKL)',
            //         ]),
            // ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }
}
