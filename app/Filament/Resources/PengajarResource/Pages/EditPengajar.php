<?php

namespace App\Filament\Resources\PengajarResource\Pages;

use App\Filament\Resources\PengajarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EditPengajar extends EditRecord
{
    protected static string $resource = PengajarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Ambil user yang terkait
        $user = User::find($this->record->user_id);

        if ($user) {

            $updateData = [
                'name' => $this->record->name,
                'email' => $this->data['email'],   // ← EMAIL dari FORM
            ];

            // Jika password diisi di form
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
