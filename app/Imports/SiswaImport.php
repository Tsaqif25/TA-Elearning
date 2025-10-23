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
        // Lewati baris kosong (nama wajib diisi)
        if (empty($row[1])) {
            return null;
        }

        //  Ambil data dengan urutan kolom Excel:
        // [0] No | [1] Nama | [2] Kelas | [3] NIS | [4] No Telp
        $nama    = trim($row[1]);
        $kelasNm = trim($row[2] ?? '');
        $nis     = trim($row[3] ?? '');
        $noTelp  = !empty($row[4]) ? trim($row[4]) : '-';

        // 🔹 Cari kelas berdasarkan nama
        $kelas = Kelas::where('name', $kelasNm)->first();
        $kelasId = $kelas ? $kelas->id : null;

        // 🔹 Validasi dasar
        if (!$kelasId) {
            throw new \Exception("Kelas '{$kelasNm}' tidak ditemukan di database. Pastikan nama kelas sesuai!");
        }

        // 🔹 Cari siswa berdasarkan NIS
        $siswa = DataSiswa::where('nis', $nis)->first();

        $data = [
            'name'      => $nama,
            'kelas_id'  => $kelasId,
            'nis'       => $nis,
            'no_telp'   => $noTelp,   //  tambahkan ini
        ];

        if ($siswa) {
            // 🔄 Update jika NIS sudah ada
            $siswa->update($data);
            $id = $siswa->id;
        } else {
            // ➕ Tambah baru jika belum ada
            $newSiswa = DataSiswa::create($data);
            $id = $newSiswa->id;
        }

        // 🧾 Simpan daftar ID yang diimport (opsional, untuk laporan)
        $importedIds = session('imported_ids', []);
        $importedIds[] = $id;
        session(['imported_ids' => $importedIds]);

        return null; // tidak perlu return model
    }

    public function startRow(): int
    {
        return 2; // Lewati baris header Excel
    }
}
