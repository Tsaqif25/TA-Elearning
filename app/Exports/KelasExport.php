<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\WithMapping;
class KelasExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
   public function collection()
    {
        return Kelas::with('mapels')->get();
    }

     public function map($kelas): array
    {
        return [
            $kelas->id,
            $kelas->name,
            $kelas->mapels->pluck('name')->implode(', '),
        ];
    }

    public function headings(): array
    {
        return [
            'Id',
            'Nama Kelas',
            'Daftar Mapel'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1:C1' => [
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
