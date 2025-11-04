<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Models\DataSiswa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class SiswaResource extends Resource
{
    protected static ?string $model = DataSiswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data Pengguna';
    protected static ?string $navigationLabel = 'Siswa';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Siswa')
                ->required(),

            Forms\Components\TextInput::make('nis')
                ->label('NIS')
                ->required(),

            Forms\Components\Select::make('kelas_id')
                ->label('Kelas')
                ->relationship('kelas', 'name')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('Email Akun')
                ->required()
                ->email(),

            Forms\Components\TextInput::make('no_telp')
                ->label('No. Telepon')
                ->nullable(),

            Forms\Components\TextInput::make('password')
                ->label('Password Awal')
                ->required()
                ->password(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Siswa')->searchable(),
                Tables\Columns\TextColumn::make('nis')->label('NIS'),
                Tables\Columns\TextColumn::make('kelas.name')->label('Kelas'),
                Tables\Columns\TextColumn::make('user.email')->label('Email Akun'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
