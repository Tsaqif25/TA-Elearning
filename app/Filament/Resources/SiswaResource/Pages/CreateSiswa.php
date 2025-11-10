<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;

    protected function afterCreate(): void
    {
        //  Buat akun user baru dari data siswa yang baru saja dibuat
        $user = User::create([
            'name' => $this->record->name,
            'email' => $this->record->email,
            'password' => Hash::make($this->data['password']),
        ]);

        //  Tambahkan role "Siswa"
        $user->assignRole('Siswa');

        //  Hubungkan siswa dengan user-nya
        $this->record->update([
            'user_id' => $user->id,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman daftar siswa setelah create
        return $this->getResource()::getUrl('index');
    }
}
