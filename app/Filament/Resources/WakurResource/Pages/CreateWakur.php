<?php

namespace App\Filament\Resources\WakurResource\Pages;

use App\Filament\Resources\WakurResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWakur extends CreateRecord
{
    protected static string $resource = WakurResource::class;

    protected function afterCreate(): void
    {
        //  Tambahkan role "Wakur" secara otomatis
        $this->record->assignRole('Wakur');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
