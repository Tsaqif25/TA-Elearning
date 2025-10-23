<?php

namespace App\Filament\Resources\PengajarResource\Pages;

use App\Filament\Resources\PengajarResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePengajar extends CreateRecord
{
    protected static string $resource = PengajarResource::class;

    protected function afterCreate(): void
    {
        //  Tambahkan role "Pengajar" secara otomatis
        $this->record->assignRole('Pengajar');
    }

    protected function getRedirectUrl(): string
    {
        //  Redirect kembali ke index, bukan ke edit
        return $this->getResource()::getUrl('index');
    }
}
