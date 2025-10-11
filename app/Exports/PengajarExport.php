<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill as fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengajarExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        // Ambil semua user dengan role 'Pengajar'
        $users = User::role('Pengajar')
            ->with(['contact', 'editorAccess.kelasMapel.kelas', 'editorAccess.kelasMapel.mapel'])
            ->get();

        $exportData = $users->map(function ($user) {
            // Ambil data kelas & mapel (bisa lebih dari satu, jadi digabung dengan koma)
            $kelasList = $user->editorAccess->map(function ($ea) {
                return $ea->kelasMapel->kelas->name ?? '-';
            })->unique()->implode(', ');

            $mapelList = $user->editorAccess->map(function ($ea) {
                return $ea->kelasMapel->mapel->name ?? '-';
            })->unique()->implode(', ');

            return [
                'id'       => $user->id,
                'nama'     => $user->name,
                'email'    => $user->email,
                'telepon'  => $user->contact->no_telp ?? '-',
                'nuptk'    => $user->contact->nuptk ?? '-',
                'nik'      => $user->contact->nik ?? '-',
                'kelas'    => $kelasList ?: '-',
                'mapel'    => $mapelList ?: '-',
            ];
        });

        return $exportData;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Nama',
            'Email',
            'Nomor Telepon',
            'Nuptk',
            'Nik',
            'Kelas',
            'Mapel',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1:H1' => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => fill::FILL_SOLID,
                    'startColor' => ['rgb' => '333333'],
                ],
            ],
        ];
    }
}
