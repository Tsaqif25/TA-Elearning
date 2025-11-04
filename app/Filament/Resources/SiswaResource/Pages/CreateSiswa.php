<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1️⃣ Buat akun user otomatis
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'kelas_id' => $data['kelas_id'],
        ]);

        // 2️⃣ Tambahkan role "Siswa"
        $user->assignRole('Siswa');

        // 3️⃣ Isi kolom user_id di tabel data_siswas
        $data['user_id'] = $user->id;

        // 4️⃣ Hapus password dari array sebelum disimpan ke data_siswas (tidak dibutuhkan di sana)
        unset($data['password']);

        return $data;
    }
}
