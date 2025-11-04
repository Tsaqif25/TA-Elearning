<?php

namespace App\Imports;

use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        // Lewati baris kosong
        if (empty($row[1])) {
            return null;
        }

        // Struktur kolom Excel:
        // [0] No | [1] Nama | [2] Kelas | [3] NIS | [4] Email | [5] Password | [6] No Telp
        $nama     = trim($row[1]);
        $kelasNm  = trim($row[2] ?? '');
        $nis      = trim($row[3] ?? '');
        $email    = strtolower(trim($row[4] ?? ''));
        $password = trim($row[5] ?? '12345678');
        $noTelp   = !empty($row[6]) ? trim($row[6]) : '-';

        // Cari kelas berdasarkan nama
        $kelas = Kelas::where('name', $kelasNm)->first();
        if (!$kelas) {
            throw new \Exception("Kelas '{$kelasNm}' tidak ditemukan di database. Pastikan nama kelas sesuai!");
        }

        DB::beginTransaction();
        try {
            // Buat / ambil akun user
            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $nama,
                    'email' => $email,
                    'password' => Hash::make($password),
                ]);
                $user->assignRole('Siswa');
            }

            // Cek apakah siswa dengan NIS sudah ada
            $siswa = DataSiswa::where('nis', $nis)->first();

            $data = [
                'name'      => $nama,
                'kelas_id'  => $kelas->id,
                'nis'       => $nis,
                'no_telp'   => $noTelp,
                'user_id'   => $user->id,
            ];

            if ($siswa) {
                $siswa->update($data);
                $id = $siswa->id;
            } else {
                $newSiswa = DataSiswa::create($data);
                $id = $newSiswa->id;
            }

            // Simpan daftar ID untuk laporan
            $importedIds = session('imported_ids', []);
            $importedIds[] = $id;
            session(['imported_ids' => $importedIds]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return null;
    }

    public function startRow(): int
    {
        return 2; // Lewati baris header
    }
}
