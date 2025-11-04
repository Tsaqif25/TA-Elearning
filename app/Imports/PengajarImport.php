<?php

namespace App\Imports;

use App\Models\User;
use App\Models\EditorAccess;
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\Mapel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PengajarImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        // Abaikan baris kosong
        if ($this->isRowEmpty($row)) return null;

        DB::beginTransaction();
        try {
            // [0] No | [1] Nama | [2] Email | [3] Password | [4] No. Telp | [5] NIP | [6] Kelas | [7] Mapel
            $nama     = trim($row[1] ?? '');
            $email    = strtolower(trim($row[2] ?? ''));
            $password = trim($row[3] ?? '');
            $noTelp   = trim($row[4] ?? '');
            $nip      = trim($row[5] ?? '');
            $kelasNm  = trim($row[6] ?? '');
            $mapelNm  = trim($row[7] ?? '');

            // Validasi dasar
            if ($nama === '' || $email === '' || $kelasNm === '' || $mapelNm === '') {
                Log::warning("⚠️ Baris dilewati karena kolom wajib kosong: {$nama} / {$email}");
                return null;
            }

            // 🔹 Pastikan user unik berdasarkan email
            $user = User::where('email', $email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $nama,
                    'email' => $email,
                    'password' => Hash::make($password ?: 'password123'),
                ]);
                $user->assignRole('Pengajar');
            } else {
                // Update nama kalau berubah
                $user->update(['name' => $nama]);
            }

            // 🔹 Pastikan kelas dan mapel sudah ada
            $kelas = Kelas::firstOrCreate(['name' => $kelasNm]);
            $mapel = Mapel::firstOrCreate(['name' => $mapelNm]);

            // 🔹 Pastikan kombinasi kelas–mapel unik
            $kelasMapel = KelasMapel::firstOrCreate([
                'kelas_id' => $kelas->id,
                'mapel_id' => $mapel->id,
            ]);

            // 🔹 Cek apakah guru ini sudah punya akses ke kombinasi ini
            $exists = EditorAccess::where('user_id', $user->id)
                ->where('kelas_mapel_id', $kelasMapel->id)
                ->exists();

            if (!$exists) {
                EditorAccess::create([
                    'user_id' => $user->id,
                    'kelas_mapel_id' => $kelasMapel->id,
                    'nip' => $nip ?: null,
                    'no_telp' => $noTelp ?: null,
                ]);
            } else {
                // Kalau sudah ada, update data tambahan saja (tidak duplikat)
                EditorAccess::where('user_id', $user->id)
                    ->where('kelas_mapel_id', $kelasMapel->id)
                    ->update([
                        'nip' => $nip ?: DB::raw('nip'),
                        'no_telp' => $noTelp ?: DB::raw('no_telp'),
                    ]);
            }

            // Simpan ID hasil import (opsional untuk notifikasi)
            $importedIds = session('imported_ids', []);
            $importedIds[] = $user->id;
            session(['imported_ids' => array_unique($importedIds)]);

            DB::commit();
            Log::info("✅ Import berhasil: {$email}");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("❌ Import gagal: " . $e->getMessage());
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
        return 2; // Lewati header Excel
    }
}
