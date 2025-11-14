<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Filament\Resources\SiswaResource\Pages;

class SiswaResource extends Resource
{
    protected static ?string $model = DataSiswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data Pengguna';
    protected static ?string $navigationLabel = 'Siswa';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // 🧩 Data Utama Siswa
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

                    Forms\Components\TextInput::make('email')
                        ->label('Email Login')
                        ->required()
                        ->email(),

                    Forms\Components\TextInput::make('password')
                        ->label('Password Login')
                        ->password()
                        ->dehydrated(false),

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
                    ->label('Email ')
                   
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
