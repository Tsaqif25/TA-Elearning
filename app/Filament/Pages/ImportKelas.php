<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KelasImport;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImportKelas extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Kelas';
    protected static ?string $title = 'Import Data Kelas';
    protected static string $view = 'filament.pages.import-kelas';
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
                ->disk('local') // Penting: simpan di local disk
                ->directory('imports') // Folder tempat upload
                ->acceptedFileTypes([
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-excel',
                    'text/csv'
                ])
                ->maxSize(5120) // Max 5MB
                ->required()
                ->helperText('Format: .xlsx, .xls, atau .csv (Max 5MB)'),
        ];
    }

    public function submit()
    {
        // Validasi form
        $data = $this->form->getState();

        if (empty($data['file'])) {
            Notification::make()
                ->title('Error!')
                ->body('File belum dipilih. Silakan upload file Excel terlebih dahulu.')
                ->danger()
                ->send();
            return;
        }

        try {
            // Reset session imported_ids
            session()->forget('imported_ids');
            session(['imported_ids' => []]);

            // Ambil path file yang sudah diupload
            $filePath = storage_path('app/' . $data['file']);

            // Import Excel
            Excel::import(new KelasImport, $filePath);

            // Ambil jumlah data yang berhasil di-import
            $count = count(session('imported_ids', []));

            // Hapus file setelah import
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Reset form
            $this->file = null;
            $this->form->fill();

            Notification::make()
                ->title('Berhasil! 🎉')
                ->body("Berhasil mengimport {$count} kelas dari file Excel.")
                ->success()
                ->duration(5000)
                ->send();

            // Redirect ke list kelas
            return redirect()->route('filament.admin.resources.kelas.index');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
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
            Notification::make()
                ->title('Gagal mengimport data! ❌')
                ->body($e->getMessage())
                ->danger()
                ->duration(10000)
                ->send();
        }
    }
}