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
                        <li><strong>Kolom B (Nama):</strong> Nama lengkap pengajar (Wajib diisi)</li>
                        <li><strong>Kolom C (Email):</strong> Email aktif pengajar (Wajib diisi)</li>
                        <li><strong>Kolom D (Password):</strong> Password login pengajar</li>
                        <li><strong>Kolom E (Nomor Telepon):</strong> Nomor HP atau WhatsApp</li>
                        <li><strong>Kolom F (NUPTK):</strong> Nomor Unik Pendidik dan Tenaga Kependidikan</li>
                        <li><strong>Kolom G (NIK):</strong> Nomor Induk Kependudukan</li>
                        <li><strong>Kolom H (Kelas):</strong> Nama kelas yang diampu (contoh: X TKJ 2)</li>
                        <li><strong>Kolom I (Mapel):</strong> Mata pelajaran yang diajar, pisahkan dengan koma jika lebih dari satu (contoh: TKJ, RPL)</li>
                    </ul>
                    <li>Upload file Excel (.xlsx atau .xls)</li>
                    <li>Klik tombol "Import Data"</li>
                </ol>

                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        ⚠️ <strong>Catatan:</strong> Jika email pengajar sudah terdaftar, sistem akan memperbarui datanya (tanpa membuat duplikat).
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Password</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Telepon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NUPTK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mapel</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 text-sm">1</td>
                            <td class="px-6 py-4 text-sm">Tsaqif Luthfan</td>
                            <td class="px-6 py-4 text-sm">tsaqifluthfan7@gmail.com</td>
                            <td class="px-6 py-4 text-sm">tsaqifluthfan123</td>
                            <td class="px-6 py-4 text-sm">08123456789</td>
                            <td class="px-6 py-4 text-sm">123456789</td>
                            <td class="px-6 py-4 text-sm">3271012345670001</td>
                            <td class="px-6 py-4 text-sm">XI RPL 1</td>
                            <td class="px-6 py-4 text-sm">TKJ, RPL</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm">2</td>
                            <td class="px-6 py-4 text-sm">Mawapres</td>
                            <td class="px-6 py-4 text-sm">mawapres@gmail.com</td>
                            <td class="px-6 py-4 text-sm">mwa123</td>
                            <td class="px-6 py-4 text-sm">082112223333</td>
                            <td class="px-6 py-4 text-sm">987654321</td>
                            <td class="px-6 py-4 text-sm">3271087654320002</td>
                            <td class="px-6 py-4 text-sm">X MPLB 2</td>
                            <td class="px-6 py-4 text-sm">TKJ</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
