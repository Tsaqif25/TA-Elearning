<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Models\DataSiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiswaResource extends Resource
{
    protected static ?string $model = DataSiswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data Pengguna';
    protected static ?string $navigationLabel = 'Siswa';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Nama Siswa')->required(),
            Forms\Components\TextInput::make('nis')->label('NIS')->required(),
            Forms\Components\Select::make('kelas_id')
                ->label('Kelas')
                ->relationship('kelas', 'name')
                ->required(),

            //      Forms\Components\TextInput::make('no_telp') 
            // ->label('Nomor Telepon')
            // ->maxLength(15)
            // ->default('-'), 
            // Forms\Components\Toggle::make('punya_akun')
            //     ->label('Sudah Punya Akun?')
            //     ->onColor('success')
            //     ->offColor('secondary'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Siswa')->searchable(),
                Tables\Columns\TextColumn::make('nis')->label('NIS'),
                Tables\Columns\TextColumn::make('kelas.name')->label('Kelas'),
                Tables\Columns\IconColumn::make('punya_akun')
                    ->boolean()
                    ->label('Punya Akun'),
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
