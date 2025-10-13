<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    protected static ?string $heading = 'Kalender Akademik';

    // Kalau belum ada data event, cukup biarkan kosong
    protected function getEvents(array $fetchInfo = []): array
    {
        return [];
    }
}
