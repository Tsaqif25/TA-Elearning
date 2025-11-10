<?php

namespace App\Filament\Resources\PengajarResource\Pages;

use App\Filament\Resources\PengajarResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreatePengajar extends CreateRecord
{
    protected static string $resource = PengajarResource::class;

    protected function afterCreate(): void
    {
        //  Buat akun user baru
        $user = User::create([
            'name' => $this->record->name,
            'email' => $this->record->email,
            'password' => Hash::make($this->data['password']),
        ]);

        //  Tambahkan role "Pengajar"
        $user->assignRole('Pengajar');

        //  Hubungkan guru dengan user-nya
        $this->record->update([
            'user_id' => $user->id,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
