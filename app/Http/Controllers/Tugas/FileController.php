<?php

namespace App\Http\Controllers\Tugas;

use App\Http\Controllers\Controller;

class FileController extends Controller
{
public function getFile($namaFile)
{
    $path = storage_path('app/public/' . $namaFile);

    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan');
    }


    // kalau mau paksa download pakai:
     return response()->download($path, basename($path));
}



    public function getFileUser($namaFile)
    {
        // $file = url('/file/tugas/user/' . $namaFile);
        $file = storage_path('app/public/file/tugas/user/' . $namaFile);

        return response()->download($file, $namaFile);
    }

    public function getFileTugas($namaFile)
    {
        // $file = url('/file/tugas/' . $namaFile);
        $file = storage_path('app/public/file/tugas/' . $namaFile);

        return response()->download($file, $namaFile);
    }
}
