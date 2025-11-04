<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImportSiswa extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Kelas';
    protected static ?string $title = 'Import Data Siswa';
    protected static string $view = 'filament.pages.import-siswa';
    protected static bool $shouldRegisterNavigation = false;

    public $file;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\FileUpload::make('file')
                ->label('Upload File Excel')
                ->disk('local')
                ->directory('imports')
                ->acceptedFileTypes([
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-excel',
                    'text/csv'
                ])
                ->maxSize(5120)
                ->required()
                ->helperText('Format: .xlsx, .xls, atau .csv (maksimal 5MB).'),
        ];
    }

    public function submit()
    {
        // 🔸 Validasi input file
        $data = $this->form->getState();

        if (empty($data['file'])) {
            Notification::make()
                ->title('Error!')
                ->body('File belum dipilih. Silakan upload file Excel terlebih dahulu.')
                ->danger()
                ->duration(5000)
                ->send();
            return;
        }

        try {
            // Reset session untuk menyimpan ID hasil import
            session()->forget('imported_ids');
            session(['imported_ids' => []]);

            // Ambil path dari file upload
            $filePath = storage_path('app/' . $data['file']);

            // Jalankan proses import
            Excel::import(new SiswaImport, $filePath);

            // Hitung jumlah data yang berhasil diimport
            $count = count(session('imported_ids', []));

            // Hapus file setelah import selesai
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Reset form upload
            $this->file = null;
            $this->form->fill();

            // Kirim notifikasi sukses
            Notification::make()
                ->title('Berhasil! 🎉')
                ->body("Berhasil mengimpor {$count} data siswa beserta akun pengguna.")
                ->success()
                ->duration(5000)
                ->send();

            // Redirect ke halaman daftar siswa (Filament Resource)
            return redirect()->route('filament.admin.resources.siswas.index');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // 🔸 Menangkap error validasi Excel (jika pakai WithValidation)
            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }

            Notification::make()
                ->title('Validasi Gagal!')
                ->body('Ada kesalahan pada file Excel: ' . implode(' | ', $errorMessages))
                ->danger()
                ->duration(10000)
                ->send();

        } catch (\Exception $e) {
            // 🔸 Tangani semua error umum (kelas tidak ditemukan, duplikat email, dsb.)
            Notification::make()
                ->title('Gagal Mengimpor Data! ❌')
                ->body($e->getMessage())
                ->danger()
                ->duration(10000)
                ->send();
        }
    }
}
