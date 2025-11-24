<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\DataSiswa;
use App\Filament\Resources\SiswaResource\Pages;
  use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class SiswaResource extends Resource
{
    protected static ?string $model = DataSiswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data Pengguna';
    protected static ?string $navigationLabel = 'Siswa';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Siswa')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required(),

                    Forms\Components\TextInput::make('nis')
                        ->label('NIS')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    Forms\Components\Select::make('kelas_id')
                        ->label('Kelas')
                        ->relationship('kelas', 'name')
                        ->required(),

                    Forms\Components\TextInput::make('no_telp')
                        ->label('Nomor Telepon')
                        ->tel()
                        ->nullable(),

                    // EMAIL
                    Forms\Components\TextInput::make('email')
                        ->label('Email Login')
                        ->required()
                        ->email()
                        ->afterStateHydrated(function ($component, $state, $record) {
                            $component->state($record?->user?->email);
                        })
                        ->dehydrated(),

                    // PASSWORD + SHOW/HIDE
                    Forms\Components\TextInput::make('password')
                        ->label('Password Login')
                        ->password()
                        ->suffixIcon('heroicon-o-eye')
                        ->extraAttributes([
                            'x-data' => "{ show: false }",
                            'x-bind:type' => "show ? 'text' : 'password'",
                            '@click.suffix' => "show = !show",
                        ])
                        ->placeholder('Kosongkan jika tidak diganti')
                        ->nullable()
                        ->dehydrated(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),

                Tables\Columns\TextColumn::make('kelas.name')
                    ->label('Kelas'),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email'),
            ])

            // FILTER JURUSAN DARI NAMA KELAS
       ->filters([
    // Filter Jurusan
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
        ->query(function ($query, array $data) {
            if ($data['value']) {
                $query->whereHas('kelas', function ($q) use ($data) {
                    $q->where('jurusan', $data['value']);
                });
            }
        }),

    // Filter Tingkat
    Tables\Filters\SelectFilter::make('tingkat')
        ->label('Filter Tingkat')
        ->options([
            'X' => 'X',
            'XI' => 'XI',
            'XII' => 'XII',
        ])
        ->query(function ($query, array $data) {
            if ($data['value']) {
                $query->whereHas('kelas', function ($q) use ($data) {
                    $q->where('tingkat', $data['value']);
                });
            }
        }),
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
 ]);

            
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
