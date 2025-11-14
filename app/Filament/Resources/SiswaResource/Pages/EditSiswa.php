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
    $user = User::find($this->record->user_id);

    if ($user) {

        $updateData = [
            'name' => $this->record->name,
            'email' => $this->data['email'], // ambil dari form
        ];

        // Update password hanya jika diisi
        if (!empty($this->data['password'])) {
            $updateData['password'] = Hash::make($this->data['password']);
        }

        $user->update($updateData);
    }
}


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
