<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kelas;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\KelasResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?string $navigationLabel = 'Kelas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // BAGIAN PEMBUATAN KELAS
            Forms\Components\Section::make('Data Kelas')
                ->schema([
                    Forms\Components\Select::make('tingkat')
                        ->label('Tingkat')
                        ->options([
                            'X' => 'X',
                            'XI' => 'XI',
                            'XII' => 'XII',
                        ])
                        ->required(),

                    Forms\Components\Select::make('jurusan')
                        ->label('Jurusan')
                        ->options([
                            'TKJ' => 'TKJ',
                            'PPLG' => 'PPLG',
                            'MPLB' => 'MPLB',
                            'AKL' => 'AKL',
                            'BD'  => 'BD',
                            'BR'  => 'BR',
                            'ULW' => 'ULW',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('rombel')
                        ->numeric()
                        ->label('Rombel')
                        ->placeholder('Contoh: 1')
                        ->required(),

                   
                ])
                ->columns(2),

            // RELASI MAPEL
            Forms\Components\Section::make('Mapel yang Diampu')
                ->schema([
                    Forms\Components\Select::make('mapels')
                        ->label('Mata Pelajaran')
                        ->relationship('mapels', 'name')
                        ->multiple()
                        ->preload()
                        ->helperText('Pilih mapel yang diajar di kelas ini.')
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kelas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tingkat')
                    ->label('Tingkat'),

                Tables\Columns\TextColumn::make('jurusan')
                    ->label('Jurusan'),

                Tables\Columns\TextColumn::make('rombel')
                    ->label('Rombel'),

                Tables\Columns\BadgeColumn::make('mapels_count')
                    ->counts('mapels')
                    ->label('Jumlah Mapel'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y'),
            ])

            // FILTER JURUSAN
            ->filters([
                Tables\Filters\SelectFilter::make('jurusan')
                    ->label('Filter Jurusan')
                    ->options([
                        'TKJ' => 'TKJ',
                        'PPLG' => 'PPLG',
                        'MPLB' => 'MPLB',
                        'AKL' => 'AKL',
                        'BD'  => 'BD',
                        'BR'  => 'BR',
                        'ULW' => 'ULW',
                    ])
                    ->query(fn ($query, array $data) =>
                        $data['value'] ? $query->where('jurusan', $data['value']) : null
                    ),

                // FILTER TINGKAT
                Tables\Filters\SelectFilter::make('tingkat')
                    ->label('Filter Tingkat')
                    ->options([
                        'X' => 'X',
                        'XI' => 'XI',
                        'XII' => 'XII',
                    ])
                    ->query(fn ($query, array $data) =>
                        $data['value'] ? $query->where('tingkat', $data['value']) : null
                    ),
            ])
             ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
             ->headerActions([
                ExportAction::make()
                    ->label('Export')
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-tray'),
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
