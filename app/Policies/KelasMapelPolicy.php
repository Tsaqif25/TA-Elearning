<?php

namespace App\Policies;

use App\Models\User;
use App\Models\KelasMapel;

class KelasMapelPolicy
{
    /**
     * Cek apakah user boleh mengakses kelas mapel ini.
     */
    public function access(User $user, KelasMapel $kelasMapel): bool
    {
        // Admin boleh semua
        if ($user->hasRole('Admin')) {
            return true;
        }

        // Kalau Pengajar → cek EditorAccess
        if ($user->hasRole('Pengajar')) {
            return $user->EditorAccess->contains('kelas_mapel_id', $kelasMapel->id);
        }

        // Kalau Siswa → cek DataSiswa (kelas_id cocok)
        if ($user->hasRole('Siswa')) {
            return $user->dataSiswa && $user->dataSiswa->kelas_id === $kelasMapel->kelas_id;
        }

        return false;
    }
}
