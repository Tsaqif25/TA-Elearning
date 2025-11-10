<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Ambil data user yang terkait
        $user = User::find($this->record->user_id);

        if ($user) {
            $user->update([
                'name' => $this->record->name,
                'email' => $this->record->email,
                // Password hanya diupdate kalau user isi ulang
                'password' => $this->record->password
                    ? Hash::make($this->record->password)
                    : $user->password,
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
