<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Instruksi --}}
        <x-filament::section>
            <x-slot name="heading">
                📋 Instruksi Import Kelas
            </x-slot>
            
            <div class="prose dark:prose-invert max-w-none">

                <p class="text-sm">
                    Gunakan fitur ini untuk menambahkan banyak data kelas sekaligus 
                    menggunakan file Excel. Format penulisan kelas sudah dibuat konsisten 
                    agar mudah difilter berdasarkan <strong>tingkat (X, XI, XII)</strong> 
                    dan <strong>jurusan (TKJ, PPLG, MPLB, dll)</strong>.
                </p>

                <ol class="list-decimal list-inside space-y-2 mt-3">
                    <li>
                        Download template Excel atau gunakan format berikut:
                    </li>

                    <ul class="list-disc list-inside ml-6">
                        <li>
                            <strong>Kolom A (Tingkat):</strong> Isi dengan <code>X</code>, 
                            <code>XI</code>, atau <code>XII</code>
                        </li>
                        <li>
                            <strong>Kolom B (Jurusan):</strong> Contoh: <code>TKJ</code>, 
                            <code>PPLG</code>, <code>MPLB</code>, dll.
                        </li>
                        <li>
                            <strong>Kolom C (Rombel):</strong> Angka rombel, contoh: 
                            <code>1</code>, <code>2</code>, <code>3</code>
                        </li>
                        <li>
                            <strong>Kolom D (Mata Pelajaran):</strong> Daftar mapel, 
                            pisahkan dengan koma (contoh: <code>K3LH, MIKROTIK</code>)
                        </li>
                    </ul>

                    <li>Upload file Excel (.xlsx atau .xls)</li>
                    <li>Klik tombol <strong>Import Data</strong></li>
                </ol>

                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        ⚠️ <strong>Catatan penting:</strong><br>
                        Sistem akan membentuk nama kelas otomatis dengan format: 
                        <strong>TINGKAT-JURUSAN ROMBEL</strong> 
                        (contoh: <code>X-TKJ 1</code>). Jika kelas sudah ada, sistem 
                        hanya menambahkan mapel yang belum dimasukkan (tanpa duplikasi).
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

                <div>
                    <x-filament::button
                        tag="a"
                        color="info"
                        href="{{ asset('storage/templates/template-kelas.xls') }}"
                        icon="heroicon-o-arrow-down-tray"
                    >
                        Download Template
                    </x-filament::button>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-filament::button
                        type="button"
                        color="gray"
                        tag="a"
                        href="{{ route('filament.admin.resources.kelas.index') }}"
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tingkat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jurusan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rombel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 text-sm">X</td>
                            <td class="px-6 py-4 text-sm">TKJ</td>
                            <td class="px-6 py-4 text-sm">1</td>
                            <td class="px-6 py-4 text-sm">K3LH, MIKROTIK</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm">XI</td>
                            <td class="px-6 py-4 text-sm">PPLG</td>
                            <td class="px-6 py-4 text-sm">2</td>
                            <td class="px-6 py-4 text-sm">WEB, BASIS DATA</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>

    </div>
</x-filament-panels::page>
