<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Mapel;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Jumlah semua pengguna terdaftar')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make('Total Kelas', Kelas::count())
                ->description('Data seluruh kelas aktif')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('success'),

            Stat::make('Total Mata Pelajaran', Mapel::count())
                ->description('Data seluruh Mata Pelajaran')
                ->descriptionIcon('heroicon-o-book-open')
                ->color('warning'),
        ];
    }
}
