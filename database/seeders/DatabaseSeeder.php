<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jalankan RoleSeeder dulu
        $this->call(RoleSeeder::class);

        // Buat user admin default jika belum ada
        if (!User::where('email', 'admin@example.com')->exists()) {
            $admin = User::create([
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('loremipsum25'),
            ]);

            // Assign role Admin
            $admin->assignRole('Admin');
        }

        // Tambah user wakur default
        if (!User::where('email', 'wakur@example.com')->exists()) {
            $wakur = User::create([
                'name' => 'Wakil Kurikulum',
                'email' => 'wakur@example.com',
                'password' => Hash::make('ipsumlorem25'),
            ]);
            $wakur->assignRole('Wakur');
        }
    }
}
