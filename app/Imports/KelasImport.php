<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\KelasMapel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KelasImport implements ToModel, WithStartRow
{

// Fungsi model() dipanggil setiap kali ada satu baris data dari file Excel
public function model(array $row)
{
    // --- 1. Validasi nama kelas ---
    if (empty($row[1])) {
        // Kalau kolom kelas kosong, langsung hentikan proses dengan error
        throw new \Exception("Nama kelas wajib diisi pada file Excel. Tidak boleh kosong.");
    }

    // --- 2. Cari atau buat kelas ---
    $kelas = Kelas::firstOrCreate(['name' => trim($row[1])]);

    // --- 3. Cek apakah ada mapel di kolom ke-3 (row[2]) ---
    if (!empty($row[2])) {
        $mapelNames = explode(',', $row[2]);

        foreach ($mapelNames as $mapelName) {
            $mapelName = trim($mapelName);

            // --- 4. Cari atau buat mapel ---
            $mapel = Mapel::firstOrCreate(['name' => $mapelName]);

            // --- 5. Hubungkan kelas dengan mapel (pivot table) ---
            KelasMapel::firstOrCreate([
                'kelas_id' => $kelas->id,
                'mapel_id' => $mapel->id
            ]);
        }
    }

    // --- 6. Simpan daftar ID kelas yang berhasil di-import ke session ---
    $importedIds = session('imported_ids', []);
    $importedIds[] = $kelas->id;
    session(['imported_ids' => $importedIds]);

    // --- 7. Return kelas ---
    return $kelas;
}


    public function startRow(): int
    {
        return 2; // Lewati header
    }
}
