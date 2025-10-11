<?php

namespace App\Exports;

use App\Models\DataSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public function collection()
    {
        return DataSiswa::with('kelas')->get();
    }

    public function map($siswa): array
    {
        return [
            $siswa->id,
            $siswa->name,
            $siswa->kelas->name,
            $siswa->nis,
        ];
    }

    public function headings(): array
    {
        return [
            'Id',
            'Nama Siswa',
            'Kelas',
            'NIS',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1:D1' => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '333333'],
                ],
            ],
        ];
    }
}
