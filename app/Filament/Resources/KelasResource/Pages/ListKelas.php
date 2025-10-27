<?php

namespace App\Filament\Resources\KelasResource\Pages;


use App\Filament\Resources\KelasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;


class ListKelas extends ListRecords
{
protected static string $resource = KelasResource::class;


protected function getHeaderActions(): array
{
return [
Actions\CreateAction::make(),


//  Tombol Import Excel custom
 Actions\Action::make('import')
 ->label('Import Excel')
 ->icon('heroicon-o-arrow-up-tray')
 ->color('success')
 ->url(route('filament.admin.pages.import-kelas')),
];
}
}

