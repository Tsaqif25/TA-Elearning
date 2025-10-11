<?php

namespace App\Imports;

use App\Models\DataSiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        // Lewati baris kosong (nama wajib)
        if (empty($row[1])) {
            return null;
        }

        // Cari siswa berdasarkan NIS
        $siswa = DataSiswa::where('nis', $row[3])->first();

        // Cari kelas berdasarkan nama
        $kelas = Kelas::where('name', trim($row[2]))->first();
        $kelasId = $kelas ? $kelas->id : null;

        $data = [
            'name'     => trim($row[1]),
            'kelas_id' => $kelasId,
            'nis'      => trim($row[3]),
        ];

        if ($siswa) {
            // Update jika NIS sudah ada
            $siswa->update($data);
            $id = $siswa->id;
        } else {
            // Insert baru
            $newSiswa = DataSiswa::create($data);
            $id = $newSiswa->id;
        }

        // Simpan daftar ID yang berhasil diimport
        $importedIds = session('imported_ids', []);
        $importedIds[] = $id;
        session(['imported_ids' => $importedIds]);

        return null; // return model opsional, bisa null
    }

    public function startRow(): int
    {
        return 2; // Lewati header
    }
}
