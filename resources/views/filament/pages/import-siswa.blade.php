<x-filament-panels::page>
    <div class="space-y-6">

        {{-- 📋 Instruksi Import --}}
        <x-filament::section>
            <x-slot name="heading">
                📋 Instruksi Import Data Siswa
            </x-slot>

            <div class="prose dark:prose-invert max-w-none">
                <p class="text-sm">
                    Untuk melakukan import data siswa, silakan gunakan file Excel dengan struktur kolom berikut:
                </p>

                <ol class="list-decimal list-inside space-y-2">
                    <li>
                        <strong>Kolom A (No):</strong> Nomor urut (boleh diisi atau dikosongkan).
                    </li>
                    <li>
                        <strong>Kolom B (Nama):</strong> Nama lengkap siswa. <span class="text-red-600 font-semibold">Wajib diisi.</span>
                    </li>
                    <li>
                        <strong>Kolom C (Kelas):</strong> Nama kelas, contoh: <code>X-TKJ 1</code>, <code>XI-RPL 2</code>.
                        <br>Pastikan sesuai format kelas yang sudah ada di sistem.
                    </li>
                    <li>
                        <strong>Kolom D (NIS):</strong> Nomor Induk Siswa. Harus unik.
                    </li>
                    <li>
                        <strong>Kolom E (Email):</strong> Email login siswa. Digunakan untuk akses aplikasi.
                    </li>
                    <li>
                        <strong>Kolom F (Password):</strong> Password login siswa (akan di-hash otomatis).
                    </li>
                    <li>
                        <strong>Kolom G (No. Telepon):</strong> Nomor telepon siswa (opsional).
                    </li>
                </ol>

               
            </div>
        </x-filament::section>

        {{-- 📤 Form Upload --}}
        <x-filament::section>
            <x-slot name="heading">
                📤 Upload File Excel
            </x-slot>

            <form wire:submit.prevent="submit">
                {{ $this->form }}

                <div class="my-3">
                    <x-filament::button
                        tag="a"
                        color="info"
                        href="{{ asset('storage/templates/template_siswa.xlsx') }}"
                        icon="heroicon-o-arrow-down-tray"
                    >
                        Download Template Excel
                    </x-filament::button>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-filament::button
                        type="button"
                        color="gray"
                        tag="a"
                        href="{{ route('filament.admin.resources.siswas.index') }}"
                    >
                        Batal
                    </x-filament::button>

                    <x-filament::button
                        type="submit"
                        color="success"
                    >
                        Import Data
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- 📊 Contoh Format --}}
        <x-filament::section>
            <x-slot name="heading">
                📊 Contoh Format Excel
            </x-slot>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">NIS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">Password</th>
                            <th class="px-6 py-3 text-left text-xs font-medium">No. Telepon</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 text-sm">1</td>
                            <td class="px-6 py-4 text-sm">Ahmad Fadillah</td>
                            <td class="px-6 py-4 text-sm">XI-TKJ 1</td>
                            <td class="px-6 py-4 text-sm">220501</td>
                            <td class="px-6 py-4 text-sm">ahmad@example.com</td>
                            <td class="px-6 py-4 text-sm">12345678</td>
                            <td class="px-6 py-4 text-sm">081234567890</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm">2</td>
                            <td class="px-6 py-4 text-sm">Siti Aulia</td>
                            <td class="px-6 py-4 text-sm">XI-TKJ 2</td>
                            <td class="px-6 py-4 text-sm">220502</td>
                            <td class="px-6 py-4 text-sm">siti@example.com</td>
                            <td class="px-6 py-4 text-sm">rahasia123</td>
                            <td class="px-6 py-4 text-sm">081234567891</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

    </div>
</x-filament-panels::page>
