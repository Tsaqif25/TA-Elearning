<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengajarResource\Pages;
use App\Models\User;
use App\Models\KelasMapel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PengajarResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data Pengguna';
    protected static ?string $navigationLabel = 'Pengajar';

    /** 🔹 tampilkan hanya user dengan role “Pengajar” */
  public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->select('users.*', 'users.password as password_plaintext')
        ->whereHas('roles', fn ($q) => $q->where('name', 'Pengajar'));
}


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Pengajar')
                ->schema([
                    Forms\Components\FileUpload::make('gambar')
                        ->label('Foto Profil')
                        ->image()
                        ->directory('foto_pengajar')
                        ->imageEditor(),

                    Forms\Components\TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required(),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->label('Email')
                        ->required(),

                  Forms\Components\TextInput::make('password')
    ->password()
    ->label('Password')
    ->required(fn(string $context) => $context === 'create')
    ->dehydrated(fn($state) => filled($state))
    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
    ->helperText('Biarkan kosong jika tidak ingin mengubah password.'),


                    Forms\Components\TextInput::make('contact.no_telp')->label('Nomor Telepon')->maxLength(15),
                    Forms\Components\TextInput::make('contact.nuptk')->label('NUPTK'),
                    Forms\Components\TextInput::make('contact.nik')->label('NIK'),
                ])
                ->columns(2),

            /** ✳️ Relasi kelas & mapel */
            Forms\Components\Section::make('Kelas & Mapel yang Diampu')
                ->description('Pilih kombinasi kelas-mapel yang diajar oleh pengajar ini.')
                ->schema([
                    Forms\Components\Repeater::make('editorAccess')
                        ->relationship()
                        ->schema([
                            Forms\Components\Select::make('kelas_mapel_id')
                                ->label('Kelas & Mapel')
                                ->options(function () {
                                    return KelasMapel::with(['kelas', 'mapel'])
                                        ->get()
                                        ->mapWithKeys(fn ($km) => [
                                            $km->id => "{$km->kelas->name} — {$km->mapel->name}"
                                        ]);
                                })
                                ->searchable()
                                ->required()
                                

                        ])
                        ->addActionLabel('Tambah Kelas & Mapel')
                        ->columns(1)
                        ->defaultItems(0),
                ]),
        ]);
    }

 public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('gambar')
                ->label('Foto')
                ->circular()
                ->defaultImageUrl('/asset/icons/profile-men.svg')
                ->width(40)
                ->height(40),

            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('contact.nuptk')->label('NUPTK')->default('-'),
            Tables\Columns\TextColumn::make('contact.nik')->label('NIK')->default('-'),

            Tables\Columns\TextColumn::make('editor_access_count')
                ->counts('editorAccess')
                ->label('Mengajar')
                ->formatStateUsing(fn ($state) => $state > 0 ? "{$state} Kelas" : 'Belum Ada')
                ->sortable(),

            Tables\Columns\TextColumn::make('email')->label('Email')->limit(20),
            Tables\Columns\TextColumn::make('contact.no_telp')->label('No Telp')->default('-'),

  

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
            'index'  => Pages\ListPengajars::route('/'),
            'create' => Pages\CreatePengajar::route('/create'),
            'edit'   => Pages\EditPengajar::route('/{record}/edit'),
        ];
    }
}
