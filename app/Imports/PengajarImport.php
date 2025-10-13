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
use Maatwebsite\Excel\Concerns\SkipsEmptyRows; // ✅ Tambahkan ini

class PengajarImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        try {
            // ✅ Filter baris yang semua kolomnya null/kosong
            if ($this->isRowEmpty($row)) {
                return null;
            }

            DB::beginTransaction();

            // 🚨 Periksa jumlah kolom minimal
            if (count($row) < 8) {
                Log::warning('⚠️ Jumlah kolom tidak sesuai. Ditemukan: ' . count($row));
                return null;
            }

            // 🚨 Periksa nama & email
            $nama = trim($row[1] ?? '');
            $email = trim($row[2] ?? '');

            if ($nama === '' || $email === '') {
                Log::warning('⚠️ Baris dilewati karena kolom nama/email kosong.');
                return null;
            }

            // 📋 Ambil semua kolom
            $data = [
                'nama'     => $nama,
                'email'    => $email,
                'password' => trim($row[3] ?? ''),
                'no_telp'  => trim($row[4] ?? ''),
                'nip'      => trim($row[5] ?? ''),
                'kelas'    => trim($row[6] ?? ''),
                'mapel'    => trim($row[7] ?? ''),
            ];

            // 🔹 Buat / update user
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['nama'],
                    'password' => Hash::make($data['password'] ?: 'password123'),
                ]
            );
            $user->assignRole('Pengajar');

            // 🔹 Buat relasi kelas_mapel jika ada
            $kelasMapelId = null;

            if (!empty($data['kelas']) && !empty($data['mapel'])) {
                $kelas = Kelas::firstOrCreate(['name' => $data['kelas']]);
                $mapel = Mapel::firstOrCreate(['name' => $data['mapel']]);

                $kelasMapel = KelasMapel::firstOrCreate([
                    'kelas_id' => $kelas->id,
                    'mapel_id' => $mapel->id,
                ]);

                $kelasMapelId = $kelasMapel->id;
            }

            // 🔹 Buat editor access
            EditorAccess::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'kelas_mapel_id' => $kelasMapelId,
                ],
                [
                    'no_telp' => $data['no_telp'] ?: null,
                    'nip' => $data['nip'] ?: null,
                ]
            );

            DB::commit();
            Log::info('✅ Import berhasil untuk: ' . $data['email']);

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Import gagal: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * ✅ Helper untuk cek apakah baris benar-benar kosong
     */
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