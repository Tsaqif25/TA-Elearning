<?php

namespace App\Filament\Resources\WakurResource\Pages;

use App\Filament\Resources\WakurResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWakur extends EditRecord
{
    protected static string $resource = WakurResource::class;
       protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
