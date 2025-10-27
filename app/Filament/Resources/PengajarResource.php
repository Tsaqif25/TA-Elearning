<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengajarResource\Pages;
use App\Models\User;
use App\Models\KelasMapel;
use App\Models\EditorAccess;
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
            ->whereHas('roles', fn($q) => $q->where('name', 'Pengajar'));
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Pengajar')
                ->schema([
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
                        ->afterStateHydrated(function (Forms\Components\TextInput $component, $state) {
                            $component->state('');
                        })
                        ->helperText('Biarkan kosong jika tidak ingin mengubah password.'),
                ])
                ->columns(2),

            // 🔹 Relasi Kelas & Mapel yang Diampu
            Forms\Components\Section::make('Kelas & Mapel yang Diampu')
                ->description('Pilih kombinasi kelas-mapel yang diajar oleh pengajar ini. Tambahkan NIP & No Telp di sini.')
                ->schema([
                    Forms\Components\Repeater::make('editorAccess')
                        ->relationship()
                        ->label(false)
                        ->schema([
                            Forms\Components\Hidden::make('id'),

                            Forms\Components\Select::make('kelas_mapel_id')
                                ->label('Kelas & Mapel')
                                ->options(function () {
                                    $used = EditorAccess::pluck('kelas_mapel_id')->toArray();

                                    return KelasMapel::with(['kelas', 'mapel'])
                                        ->get()
                                        ->mapWithKeys(function ($km) use ($used) {
                                            $label = "{$km->kelas->name} — {$km->mapel->name}";
                                            if (in_array($km->id, $used)) {
                                                $label .= " (Sudah Diampu)";
                                            }
                                            return [$km->id => $label];
                                        });
                                })
                                ->searchable()
                                ->required()
                                ->rule(function ($get, $record) {
                                    return function (string $attribute, $value, $fail) use ($record, $get) {
                                        $userId = $record?->id;
                                        $editorAccessId = $get('id'); 

                                        $exists = EditorAccess::where('kelas_mapel_id', $value)
                                            ->when($userId, fn($q) => $q->where('user_id', '!=', $userId))
                                            ->when($editorAccessId, fn($q) => $q->where('id', '!=', $editorAccessId))
                                            ->exists();

                                        if ($exists) {
                                            $fail('Kelas & Mapel ini sudah diampu oleh pengajar lain.');
                                        }
                                    };
                                })
                                ->disableOptionWhen(function ($value, $state, $get, $record) {
                                    $userId = $record?->id;
                                    $editorAccessId = $get('id');

                                    $exists = EditorAccess::where('kelas_mapel_id', $value)
                                        ->when($userId, fn($q) => $q->where('user_id', '!=', $userId))
                                        ->when($editorAccessId, fn($q) => $q->where('id', '!=', $editorAccessId))
                                        ->exists();

                                    return $exists;
                                }),

                            Forms\Components\TextInput::make('nip')
                                ->label('NIP (Opsional)')
                                ->maxLength(30),

                            Forms\Components\TextInput::make('no_telp')
                                ->label('Nomor Telepon (Opsional)')
                                ->maxLength(15),
                        ])
                        ->addActionLabel('Tambah Kelas & Mapel')
                        ->columns(2)
                        ->defaultItems(0),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->getStateUsing(fn($record) => optional($record->editorAccess->first())->nip ?? '-'),

                Tables\Columns\TextColumn::make('editorAccessNoTelp')
                    ->label('No. Telp')
                    ->getStateUsing(fn($record) => optional($record->editorAccess->first())->no_telp ?? '-'),

                Tables\Columns\TextColumn::make('editor_access_count')
                    ->counts('editorAccess')
                    ->label('Mengajar')
                    ->formatStateUsing(fn($state) => $state > 0 ? "{$state} Kelas" : 'Belum Ada')
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->limit(20),
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
            'index' => Pages\ListPengajars::route('/'),
            'create' => Pages\CreatePengajar::route('/create'),
            'edit' => Pages\EditPengajar::route('/{record}/edit'),
        ];
    }
}
