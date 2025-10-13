<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Contact;
use App\Models\EditorAccess; 
use App\Models\Kelas;
use App\Models\KelasMapel;
use App\Models\Mapel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PengajarImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        try {
            DB::beginTransaction();

            // 1. VALIDASI & PARSING DATA
            $data = $this->parseRowData($row);
            if (!$data) {
                return null;
            }

            // 2. BUAT/UPDATE USER & CONTACT
            $user = $this->createOrUpdateUser($data);

            // 3. ASSIGN KELAS & MAPEL
            if ($data['kelas'] && $data['mapel']) {
                $this->assignKelasMapel($user, $data['kelas'], $data['mapel']);
            }

            DB::commit();
            Log::info('✅ Import berhasil: ' . $user->email);
            
            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Import gagal: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Parse dan validasi data dari row Excel
     */
    private function parseRowData(array $row)
    {
        // Email wajib ada
        if (empty($row[2])) {
            Log::warning('⚠️ Email kosong, skip baris');
            return null;
        }

      return [
    'nama'   => !empty($row[1]) ? trim($row[1]) : null,
    'email'  => trim($row[2]),
    'password' => !empty($row[3]) ? trim($row[3]) : null,
    'no_telp' => $this->cleanValue($row[4] ?? null),
    'nuptk'  => $this->cleanValue($row[5] ?? null),
    'nik'    => $this->cleanValue($row[6] ?? null),
    'kelas'  => !empty($row[7]) ? trim($row[7]) : null,
    'mapel'  => !empty($row[8]) ? trim($row[8]) : null,
];

    }

    /**
     * Bersihkan nilai kosong atau dash
     */
    private function cleanValue($value)
    {
        if (empty($value) || $value === '-' || $value === '') {
            return null;
        }
        return trim($value);
    }

    /**
     * Buat user baru atau update yang sudah ada
     */
    private function createOrUpdateUser(array $data)
    {
        $user = User::where('email', $data['email'])->first();

   if ($user) {
    // UPDATE user yang sudah ada
    Log::info('🔄 Update user: ' . $data['email']);

    if ($data['nama']) {
        $user->update(['name' => $data['nama']]);
    }

    // Jika import menyertakan kolom password dan tidak kosong, hash lalu update
    if (!empty($data['password'])) {
        $user->update(['password' => Hash::make($data['password'])]);
    }

    $this->ensurePengajarRole($user);
    $this->updateContact($user, $data);

} else {
    // BUAT user baru
    Log::info('➕ Buat user baru: ' . $data['email']);
    
    if (!$data['nama']) {
        throw new \Exception('Nama wajib diisi untuk user baru!');
    }

    $user = User::create([
        'name'     => $data['nama'],
        'email'    => $data['email'],
        // Jika password dari Excel ada → hash-nya, kalau tidak pakai default 'password123' (juga di-hash)
        'password' => Hash::make($data['password'] ?? 'password123'),
    ]);

    $user->assignRole('Pengajar');
    
    Contact::create([
        'user_id' => $user->id,
        'no_telp' => $data['no_telp'],
        'nuptk'   => $data['nuptk'],
        'nik'     => $data['nik'],
    ]);
}

        return $user;
    }

    /**
     * Pastikan user punya role Pengajar
     */
    private function ensurePengajarRole(User $user)
    {
        if (!$user->hasRole('Pengajar')) {
            $user->assignRole('Pengajar');
            Log::info('👤 Role Pengajar ditambahkan');
        }
    }

    /**
     * Update contact, jaga data lama kalau field baru kosong
     */
    private function updateContact(User $user, array $data)
    {
        $existingContact = Contact::where('user_id', $user->id)->first();
        
        Contact::updateOrCreate(
            ['user_id' => $user->id],
            [
                'no_telp' => $data['no_telp'] ?? $existingContact?->no_telp,
                'nuptk'   => $data['nuptk'] ?? $existingContact?->nuptk,
                'nik'     => $data['nik'] ?? $existingContact?->nik,
            ]
        );
    }

    /**
     * Assign pengajar ke kelas dan mapel
     */
    private function assignKelasMapel(User $user, string $kelasName, string $mapelString)
    {
        // Cari atau buat kelas
        $kelas = Kelas::firstOrCreate(['name' => $kelasName]);

        // Pisah mapel dengan koma
        $mapelList = array_filter(
            array_map('trim', explode(',', $mapelString))
        );

        foreach ($mapelList as $mapelName) {
            // Cari atau buat mapel
            $mapel = Mapel::firstOrCreate(['name' => $mapelName]);

            // Hubungkan kelas dengan mapel
            $kelasMapel = KelasMapel::firstOrCreate([
                'kelas_id' => $kelas->id,
                'mapel_id' => $mapel->id,
            ]);

            // Beri akses ke pengajar
            EditorAccess::firstOrCreate([
                'user_id'        => $user->id,
                'kelas_mapel_id' => $kelasMapel->id,
            ]);

            Log::info(" {$user->email} → {$kelas->name} → {$mapel->name}");
        }
    }

    public function startRow(): int
    {
        return 2; // Skip header
    }
}