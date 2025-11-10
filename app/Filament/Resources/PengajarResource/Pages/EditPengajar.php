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
        // 🧩 Update data user yang terhubung
        $user = User::find($this->record->user_id);

        if ($user) {
            $user->update([
                'name' => $this->record->name,
                'email' => $this->record->email,
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
