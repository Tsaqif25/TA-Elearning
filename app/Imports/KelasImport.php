<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\KelasMapel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KelasImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        // ---------------------------
        // 1. Ambil data per kolom Excel
        // ---------------------------
        $tingkat = trim($row[0] ?? null);   // X, XI, XII
        $jurusan = trim($row[1] ?? null);   // TKJ, PPLG, dll
        $rombel  = trim($row[2] ?? null);   // angka rombel
        $mapelStr = trim($row[3] ?? null);  // K3LH,MIKROTIK,...

        // ---------------------------
        // 2. Validasi wajib
        // ---------------------------
        if (!$tingkat || !$jurusan || !$rombel) {
            throw new \Exception("Tingkat, Jurusan, dan Rombel wajib diisi pada Excel.");
        }

        // ---------------------------
        // 3. Bentuk nama kelas otomatis
        // ---------------------------
        $jurusan = strtoupper($jurusan);
        $kelasName = "{$tingkat}-{$jurusan} {$rombel}";

        // ---------------------------
        // 4. Cari atau buat kelas
        // ---------------------------
        $kelas = Kelas::firstOrCreate(
            ['name' => $kelasName],
            [
                'tingkat' => $tingkat,
                'jurusan' => $jurusan,
                'rombel'  => $rombel,
            ]
        );

        // ---------------------------
        // 5. Proses mata pelajaran
        // ---------------------------
 // ===========================
// 5. Proses mata pelajaran
// ===========================
if (!empty($mapelStr)) {

    $mapelNames = explode(',', $mapelStr);

    foreach ($mapelNames as $mapelName) {

        $mapelName = trim($mapelName);
        if ($mapelName === "") continue;

        // CEK mapel harus sudah ada
        $mapel = Mapel::where('name', $mapelName)->first();

        if (!$mapel) {
            throw new \Exception("Mapel '{$mapelName}' tidak ditemukan di tabel mapel! 
Silakan tambahkan mapel tersebut terlebih dahulu.");
        }

        // Hubungkan kelas dengan mapel
        KelasMapel::firstOrCreate([
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
        ]);
    }
}


        // ---------------------------
        // 6. Simpan ID kelas yang sukses
        // ---------------------------
        $imported = session('imported_ids', []);
        $imported[] = $kelas->id;
        session(['imported_ids' => $imported]);

        return $kelas;
    }


    public function startRow(): int
    {
        return 2; // Lewati header Excel
    }
}
