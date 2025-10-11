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
                'password' => Hash::make('password'),
            ]);

            // Assign role Admin
            $admin->assignRole('Admin');
        }
    }
}
