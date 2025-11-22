<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Guru;
use App\Models\KelasMapel;
use App\Models\PengajarKelasMapel;
use App\Filament\Resources\PengajarResource\Pages;

class PengajarResource extends Resource
{
    protected static ?string $model = Guru::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data Pengguna';
    protected static ?string $navigationLabel = 'Pengajar';

    public static function getEloquentQuery(): Builder
    {
        return Guru::query()->orderBy('name');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            // 📘 Data utama pengajar
            Forms\Components\Section::make('Data Pengajar')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required(),

                    Forms\Components\TextInput::make('nip')
                        ->label('NIP')
                        ->unique(ignoreRecord: true)
                        ->required(),

          Forms\Components\TextInput::make('email')
    ->label('Email Login')
    ->required()
    ->email()
    ->afterStateHydrated(function ($component, $state, $record) {
        $component->state($record?->user?->email); // TAMPILKAN EMAIL LAMA
    })
    ->dehydrated(), // KIRIM KE BACKEND

Forms\Components\TextInput::make('password')
    ->label('Password Login')
    ->password()
    ->placeholder('Kosongkan jika tidak diganti')
    ->nullable()
    ->dehydrated()
    ->suffixIcon('heroicon-o-eye')
    ->extraAttributes([
        'x-data' => '{ show: false }',
        'x-bind:type' => "show ? 'text' : 'password'",
        '@click.suffix' => "show = !show",
    ]),

                ])
                ->columns(2),

            // 🧩 Kelas & mapel yang diampu
            Forms\Components\Section::make('Kelas & Mapel yang Diampu')
                ->schema([
                    Forms\Components\Repeater::make('pengajarKelasMapels')
                        ->relationship()
                        ->label(false)
                        ->schema([
                            Forms\Components\Select::make('kelas_mapel_id')
                                ->label('Kelas & Mapel')
                                ->options(function () {
                                    return KelasMapel::with(['kelas', 'mapel'])
                                        ->get()
                                        ->mapWithKeys(fn($km) => [
                                            $km->id => "{$km->kelas->name} — {$km->mapel->name}"
                                        ]);
                                })
                                ->required()
                                ->searchable()
                                ->disableOptionWhen(function ($value) {
                                    // Tidak bisa pilih kalau sudah diajar guru lain
                                    return PengajarKelasMapel::where('kelas_mapel_id', $value)->exists();
                                })
                                ->helperText('Jika kombinasi kelas–mapel sudah diampu guru lain, pilihannya akan nonaktif.'),
                        ])
                        ->addActionLabel('Tambah Kelas & Mapel')
                        ->defaultItems(0)
                        ->columns(1),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengajar')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    // ->limit(25),
            ])
                ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengajars::route('/'),
            'create' => Pages\CreatePengajar::route('/create'),
            'edit' => Pages\EditPengajar::route('/{record}/edit'),
        ];
    }
}
