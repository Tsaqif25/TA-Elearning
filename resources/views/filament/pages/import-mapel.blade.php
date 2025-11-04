<x-filament-panels::page>
    <div class="space-y-6">
        {{-- 📋 Instruksi Import --}}
        <x-filament::section>
            <x-slot name="heading">
                📋 Instruksi Import
            </x-slot>
            
            <div class="prose dark:prose-invert max-w-none">
                <ol class="list-decimal list-inside space-y-2">
                    <li>Gunakan format Excel berikut:</li>
                    <ul class="list-disc list-inside ml-6">
                        <li><strong>Kolom A (No):</strong> Nomor urut</li>
                        <li><strong>Kolom B (Nama Mapel):</strong> Nama mapel <em>(Wajib diisi)</em></li>
                        <li><strong>Kolom C (Deskripsi):</strong> Keterangan atau penjelasan singkat tentang mapel (Opsional)</li>
                    </ul>
                    <li>Upload file Excel dengan format <code>.xlsx</code>, <code>.xls</code>, atau <code>.csv</code>.</li>
                    <li>Klik tombol <strong>"Import Data"</strong>.</li>
                </ol>

                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        ⚠️ <strong>Catatan:</strong> Jika nama mapel sudah ada, sistem akan otomatis memperbarui data tersebut tanpa membuat duplikasi.
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
                <div>
         <x-filament::button
    tag="a"
    color="info"
    href="{{ asset('storage/templates/template_mapel.xlsx') }}"
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
                        href="{{ route('filament.admin.resources.mapels.index') }}"
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Mapel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi (Opsional)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 text-sm">1</td>
                            <td class="px-6 py-4 text-sm">Matematika</td>
                            <td class="px-6 py-4 text-sm">Dasar perhitungan numerik dan logika</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm">2</td>
                            <td class="px-6 py-4 text-sm">Fisika</td>
                            <td class="px-6 py-4 text-sm">Ilmu yang mempelajari energi dan materi</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm">3</td>
                            <td class="px-6 py-4 text-sm">Bahasa Inggris</td>
                            <td class="px-6 py-4 text-sm">Pemahaman dan komunikasi bahasa Inggris</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
