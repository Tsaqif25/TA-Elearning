<?php

namespace App\Http\Controllers\Tugas;

use App\Http\Controllers\Controller;

class FileController extends Controller
{
    //  File Materi
public function getFile($namaFile)
{
    $path = storage_path('app/public/' . $namaFile);

    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan');
    }

    return response()->file($path);
}


    //  File Tugas
    public function getFileTugas($namaFile)
    {
        $path = storage_path('app/public/file/tugas/' . $namaFile);

        if (!file_exists($path)) {
            abort(404, 'File tugas tidak ditemukan');
        }

        return response()->file($path);
    }

    //  File User (siswa)
    public function getFileUser($namaFile)
    {
        $path = storage_path('app/public/file/tugas/user/' . $namaFile);

        if (!file_exists($path)) {
            abort(404, 'File user tidak ditemukan');
        }

        return response()->file($path);
    }
}
