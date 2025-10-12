<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Instruksi --}}
        <x-filament::section>
            <x-slot name="heading">
                📋 Instruksi Import
            </x-slot>
            
            <div class="prose dark:prose-invert max-w-none">
                <ol class="list-decimal list-inside space-y-2">
                    <li>Download template Excel atau gunakan format berikut:</li>
                    <ul class="list-disc list-inside ml-6">
                        <li><strong>Kolom A (No):</strong> Nomor urut</li>
                        <li><strong>Kolom B (Nama Kelas):</strong> Nama kelas (Wajib diisi)</li>
                        <li><strong>Kolom C (Mata Pelajaran):</strong> Nama mapel, pisahkan dengan koma jika lebih dari 1</li>
                    </ul>
                    <li>Upload file Excel (.xlsx atau .xls)</li>
                    <li>Klik tombol "Import Data"</li>
                </ol>

                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        ⚠️ <strong>Catatan:</strong> Jika nama kelas sudah ada, sistem akan menambahkan mapel baru tanpa duplikasi.
                    </p>
                </div>
            </div>
        </x-filament::section>

        {{-- Form Upload --}}
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
                        href="{{ route('filament.admin.resources.pengajars.index') }}"
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

        {{-- Contoh Format --}}
        <x-filament::section>
            <x-slot name="heading">
                📊 Contoh Format Excel
            </x-slot>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 text-sm">1</td>
                            <td class="px-6 py-4 text-sm">X IPA 1</td>
                            <td class="px-6 py-4 text-sm">Matematika, Fisika, Kimia</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm">2</td>
                            <td class="px-6 py-4 text-sm">X IPA 2</td>
                            <td class="px-6 py-4 text-sm">Matematika, Biologi</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>