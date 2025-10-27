<?php

namespace App\Filament\Resources\SiswaResource\Pages;


use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;


class ListSiswas extends ListRecords
{
protected static string $resource = SiswaResource::class;


protected function getHeaderActions(): array
{
return [
Actions\CreateAction::make(),


// 🔹 Tombol Import Excel custom
// Actions\Action::make('import')
// ->label('Import Excel')
// ->icon('heroicon-o-arrow-up-tray')
// ->color('success')
// ->url(route('filament.admin.pages.import-siswa')),
];
}
}

