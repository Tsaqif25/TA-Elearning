<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\KelasMapel;
use App\Models\PengajarKelasMapel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PengajarImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        if ($this->isRowEmpty($row)) return null;

        $nama     = trim($row[1] ?? '');
        $email    = strtolower(trim($row[2] ?? ''));
        $password = trim($row[3] ?? '');
        $noTelp   = trim($row[4] ?? '');
        $nip      = trim($row[5] ?? '');
        $kelasNm  = trim($row[6] ?? '');
        $mapelNm  = trim($row[7] ?? '');

        if ($nama === '' || $email === '' || $kelasNm === '' || $mapelNm === '') {
            Log::warning("❌ Lewat baris karena kosong: {$nama} | {$email}");
            return null;
        }

        DB::beginTransaction();
        try {

            // === 1. USER ===
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $nama,
                    'password' => Hash::make($password ?: 'password123'),
                ]
            );

            if (!$user->hasRole('Pengajar')) {
                $user->assignRole('Pengajar');
            }

            $user->update(['name' => $nama]);

            // === 2. GURU ===
            $guru = Guru::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name'     => $nama,
                    'nip'      => $nip ?: null,
                    'no_telp'  => $noTelp ?: null,
                ]
            );

            $guru->update([
                'name'     => $nama,
                'nip'      => $nip ?: $guru->nip,
                'no_telp'  => $noTelp ?: $guru->no_telp,
            ]);

            // ========== 3. VALIDASI KELAS ==========
            $kelas = Kelas::where('name', $kelasNm)->first();
            if (!$kelas) {
                throw new \Exception("Kelas '{$kelasNm}' tidak ditemukan! Tambahkan dulu di menu Kelas.");
            }

            // ========== 4. VALIDASI MAPEL ==========
            $mapel = Mapel::where('name', $mapelNm)->first();
            if (!$mapel) {
                throw new \Exception("Mapel '{$mapelNm}' tidak ditemukan! Tambahkan dulu di menu Mata Pelajaran.");
            }

            // === 5. KELAS MAPEL ===
            $kelasMapel = KelasMapel::firstOrCreate([
                'kelas_id' => $kelas->id,
                'mapel_id' => $mapel->id,
            ]);

            // === 6. PENGAJAR – KELAS_MAPEL ===
            PengajarKelasMapel::firstOrCreate([
                'guru_id' => $guru->id,
                'kelas_mapel_id' => $kelasMapel->id,
            ]);

            DB::commit();
            Log::info("✅ Import OK: {$email}");

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("❌ Error Import: " . $e->getMessage());
            throw $e;
        }

        return null;
    }


    private function isRowEmpty(array $row): bool
    {
        foreach ($row as $cell) {
            if (!is_null($cell) && trim($cell) !== '') {
                return false;
            }
        }
        return true;
    }

    public function startRow(): int
    {
        return 2;
    }
}
