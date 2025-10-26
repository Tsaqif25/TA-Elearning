<?php

namespace App\Filament\Resources\WakurResource\Pages;

use App\Filament\Resources\WakurResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWakurs extends ListRecords
{
    protected static string $resource = WakurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
