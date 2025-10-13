<x-filament-panels::page>
    <div class="space-y-6">
        {{-- 📋 Instruksi Import --}}
        <x-filament::section>
            <x-slot name="heading">
                📋 Instruksi Import
            </x-slot>
            
            <div class="prose dark:prose-invert max-w-none">
                <ol class="list-decimal list-inside space-y-2">
                    <li>Download template Excel atau gunakan format berikut:</li>
                    <ul class="list-disc list-inside ml-6">
                        <li><strong>Kolom A (No):</strong> Nomor urut</li>
                        <li><strong>Kolom B (Nama Siswa):</strong> Nama lengkap siswa (Wajib diisi)</li>
                        <li><strong>Kolom C (Kelas):</strong> Nama kelas tempat siswa terdaftar (contoh: X RPL 1)</li>
                        <li><strong>Kolom D (NIS):</strong> Nomor Induk Siswa (unik untuk tiap siswa)</li>
                    </ul>
                    <li>Upload file Excel (.xlsx atau .xls)</li>
                    <li>Klik tombol "Import Data"</li>
                </ol>

                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        ⚠️ <strong>Catatan:</strong> 
                        Jika NIS sudah ada, sistem akan memperbarui data siswa tersebut secara otomatis tanpa membuat duplikat.
                        Jika nama kelas tidak ditemukan di database, maka siswa akan tetap diimport namun tanpa kelas.
                    </p>
                </div>
            </div>
        </x-filament::section>

        {{-- 📤 Form Upload --}}
        <x-filament::section>
            <x-slot name="heading">
                📤 Upload File Excel
            </x-slot>

            <form wire:submit.prevent="submit">
                {{ $this->form }}

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

        {{-- 📊 Contoh Format Excel --}}
        <x-filament::section>
            <x-slot name="heading">
                📊 Contoh Format Excel
            </x-slot>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 text-sm">1</td>
                            <td class="px-6 py-4 text-sm">Andi Pratama</td>
                            <td class="px-6 py-4 text-sm">X TKJ 2</td>
                            <td class="px-6 py-4 text-sm">2024001</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm">2</td>
                            <td class="px-6 py-4 text-sm">Siti Rahma</td>
                            <td class="px-6 py-4 text-sm">XI RPL 1</td>
                            <td class="px-6 py-4 text-sm">2024002</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
