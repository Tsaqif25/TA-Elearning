<?php

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use App\Models\Contact;
use App\Models\DataSiswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;


class DataSiswaController extends Controller
{
    
    public function viewSiswa()
    {
       
        return view('menu.admin.controlSiswa.viewSiswa', ['title' => 'Data Siswa', 'siswa' => DataSiswa::paginate(10), 'dataKelas' => Kelas::get()]);
    }

    
public function searchSiswa(Request $request)
{
    // Validasi input keyword
    $request->validate([
        'keyword' => ['required', 'string', 'max:255'],
    ]);

    $keyword = $request->keyword;

    // Query pencarian siswa berdasarkan nama & nis
    $siswa = DataSiswa::where('name', 'LIKE', "%{$keyword}%")
        ->orWhere('nis', 'LIKE', "%{$keyword}%")
        ->paginate(15);

    // Kirim ke view
    return view('menu.admin.controlSiswa.search', [
        'siswa'   => $siswa,
        'keyword' => $keyword,
        'title'   => 'Hasil Pencarian Siswa',
    ]);
}

 public function viewTambahSiswa()
{
   
    $dataKelas = Kelas::all();

    return view('menu.admin.controlSiswa.viewTambahSiswa', compact( 'dataKelas'))
        ->with('title', 'Tambah Siswa');
}

public function validateDataSiswa(Request $request)
{
    
    $validated = $request->validate([
        'nama'  => 'required|string|max:255',
        'kelas' => 'required|exists:kelas,id',
        'nis'   => 'required|unique:data_siswas',
    ]);

    
    DataSiswa::create([
        'name'     => $validated['nama'],
        'kelas_id' => $validated['kelas'],
        'nis'      => $validated['nis'],
    ]);

   
    return redirect()->route('viewSiswa')
        ->with('success', 'Data siswa berhasil ditambahkan!');
}


   
    public function viewUpdateDataSiswa(DataSiswa $DataSiswa)
    {
       
        return view('menu.admin.controlSiswa.updateSiswa', ['title' => 'Update Siswa', 'siswa' => $DataSiswa, 'dataKelas' => Kelas::get()]);
    }

     public function updateDataSiswa(Request $request)
{
    // Cari siswa berdasarkan ID
    $siswa = DataSiswa::findOrFail($request->id);

    // Validasi utama
    $request->validate([
        'nama'  => 'required',
        'kelas' => 'required',
        'nis'   => 'required|unique:data_siswas,nis,' . $siswa->id,
    ]);

    // Jika siswa punya akun, update user terkait
    if ($siswa->punya_akun && $siswa->user_id) {
        User::where('id', $siswa->user_id)->update([
            'kelas_id' => $request->kelas,
            'name'     => $request->nama,
        ]);
    }

    // Update data siswa
    $siswa->update([
        'name'     => $request->nama,
        'kelas_id' => $request->kelas,
        'nis'      => $request->nis,
    ]);

    return back()->with('success', 'Update berhasil!');
}



public function destroyDataSiswa(Request $request)
{
    // Cari data siswa
    $siswa = DataSiswa::find($request->idHapus);

    if (!$siswa) {
        return redirect()->back()->with('error', 'Data siswa tidak ditemukan!');
    }

    // Jika ada akun terkait, hapus juga
    if ($siswa->punya_akun && $siswa->user_id) {
        User::destroy($siswa->user_id);
    }

    // Hapus data siswa
    $siswa->delete();

    return redirect()->back()->with('delete-success', 'Berhasil menghapus Data Siswa!');
}


    public function export()
    {
        return Excel::download(new SiswaExport, 'export-siswa.xls');
    }

    
    public function import(Request $request)
    {
        // Melakukan validasi jenis file yang diizinkan.
        $request->validate([
            'file' => 'required|mimes:xlsx,xls', // Sesuaikan dengan jenis file Excel yang diizinkan
        ]);
        session()->forget('imported_ids', []);

        // Proses impor data dari Excel.
        try {
            Excel::import(new SiswaImport, $request->file('file')); // Gantilah dengan nama sesuai nama kelas impor Anda
            $ids = session()->get('imported_ids');
            DataSiswa::whereNotIn('id', $ids)->delete();
            // Hapus akses editor dll

            return redirect()->route('viewSiswa')->with('import-success', 'Data Siswa berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->route('viewSiswa')->with('import-error', 'Error : ' . $e->getMessage());
        }
    }

   
    public function contohSiswa()
    {
        // File Excel disimpan dalam direktori ini.
        $file = public_path('/examples/contoh-data-siswa.xls');

        return response()->download($file, 'contoh-siswa.xls');
    }

   
    public function viewUpdateUserSiswa($token)
    {
        try {
          
            $id = Crypt::decrypt($token);
         
            $profile = User::findOrFail($id);
            $contact = Contact::where('user_id', $id)->first();
            $kelas = Kelas::get();

          
            return view('menu.admin.controlSiswa.user.updateUser', ['user' => $profile, 'contact' => $contact, 'kelas' => $kelas, 'title' => 'Profile']);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            
            abort(404);
        }
    }

   
    public function updateUserSiswa(Request $request)
    {
        // Mengambil data dari request.
        $data = $request->all();

        if (Auth()->User()->roles_id == 1) {
            // Untuk Admin

            // Mendapatkan data yang diperlukan (nama, jenis kelamin, email, dan password jika diubah).
            $nama = $data['nama'];
            $email = $data['email'];

            if ($data['password'] != null) {
                $password = bcrypt($data['password']); // Mengenkripsi password jika diubah.

                // Memperbarui data pengguna (nama, jenis kelamin, email, dan password jika diubah).
                $temp = [
                    'name' => $nama,
                    'email' => $email,
                    'password' => $password,

                ];

                User::where('id', $data['id'])->update($temp);

                // Mengubah jenis kelamin menjadi format yang sesuai.

                $temp2 = [
                    'name' => $nama,

                ];

                // Memperbarui data siswa.
                DataSiswa::where('user_id', $data['id'])->update($temp2);
            } else {
                // Jika password tidak diubah, hanya memperbarui data pengguna (nama, jenis kelamin, email).
                $temp = User::where('id', $data['id'])->update([
                    'name' => $nama,
                    'email' => $email,
                ]);

                $temp2 = [
                    'name' => $nama,
                ];

                // Memperbarui data siswa.
                DataSiswa::where('user_id', $data['id'])->update($temp2);
            }

            // Memperbarui data kontak (nomor telepon).
            Contact::where('user_id', $data['id'])->update([
                'no_telp' => $request->noTelp,
            ]);

            // Melakukan commit transaksi database.
            DB::commit();

            // Mengarahkan kembali dengan pesan sukses.
            return redirect()->back()->with('success', 'Update berhasil!');
        } elseif (Auth()->User()->roles_id == 1 && Auth()->User()->id == $data['id']) {
            // Untuk Siswa

            // Mendapatkan data email.
            $email = $data['email'];

            // Memperbarui data pengguna (email).
            $temp = User::where('id', $data['id'])->update([
                'email' => $email,
            ]);

            // Memperbarui data kontak (nomor telepon).
            Contact::where('user_id', $data['id'])->update([
                'no_telp' => $request->noTelp,
            ]);

            // Melakukan commit transaksi database.
            DB::commit();

            // Mengarahkan kembali dengan pesan sukses.
            return redirect()->back()->with('success', 'Update berhasil!');
        } elseif (Auth()->User()->roles_id == 2 && Auth()->User()->id == $data['id']) {
            // Untuk Pengajar

            // Mendapatkan data email dan deskripsi.
            $email = $data['email'];
            $deskripsi = $data['deskripsi'];

            // Memperbarui data pengguna (email dan deskripsi).
            $temp = User::where('id', $data['id'])->update([
                'email' => $email,
                'deskripsi' => $deskripsi,
            ]);

            // Memperbarui data kontak (nomor telepon).
            Contact::where('user_id', $data['id'])->update([
                'no_telp' => $request->noTelp,
            ]);

            // Melakukan commit transaksi database.
            DB::commit();

            // Mengarahkan kembali dengan pesan sukses.
            return redirect()->back()->with('success', 'Update berhasil!');
        } elseif (Auth()->User()->roles_id == 3 && Auth()->User()->id == $data['id']) {
            $user = User::find(Auth()->User()->id);

            if ($user->email == $data['email']) {
            } else {
                $request->validate([
                    'email' => 'required|email|unique:users',
                ]);
            }

            if ($data['password'] != null) {
                $request->validate([
                    'password' => 'required|min:8',
                    'confirm-password' => 'required|min:8|same:password',
                ]);
            }

            if ($data['password'] != null) {
                // Mendapatkan data email dan deskripsi.
                $email = $data['email'];

                // Memperbarui data pengguna (email dan deskripsi).
                $temp = User::where('id', $data['id'])->update([
                    'email' => $email,
                    'password' => Hash::make($data['password']),
                ]);

                // Memperbarui data kontak (nomor telepon).
                Contact::where('user_id', $data['id'])->update([
                    'no_telp' => $request->noTelp,
                ]);

                // Melakukan commit transaksi database.
                DB::commit();
            } else {
                // Mendapatkan data email dan deskripsi.
                $email = $data['email'];

                // Memperbarui data pengguna (email dan deskripsi).
                $temp = User::where('id', $data['id'])->update([
                    'email' => $email,
                ]);

                // Memperbarui data kontak (nomor telepon).
                Contact::where('user_id', $data['id'])->update([
                    'no_telp' => $request->noTelp,
                ]);

                // Melakukan commit transaksi database.
                DB::commit();
            }

            // Mengarahkan kembali dengan pesan sukses.
            return redirect()->back()->with('success', 'Update berhasil!');
        } else {
            // Menampilkan halaman 404 jika peran pengguna tidak sesuai.
            abort(404);
        }
    }

   
    public function viewSiswaKelas(Request $request)
    {
        // Memeriksa apakah parameter 'kelasName' tidak null.
        if ($request->kelasName != null) {
            // Mencari ID kelas berdasarkan nama kelas yang diberikan.
            $num = Kelas::where('name', $request->kelasName)->first();

            // Mengambil daftar siswa yang terkait dengan ID kelas.
            $siswa = DataSiswa::where('kelas_id', $num['id'])->get();
            $data = [];

            // Iterasi melalui daftar siswa dan mengambil data yang diperlukan.
            foreach ($siswa as $key) {
                // Mengambil data pengguna terkait.
                $temp = User::where('id', $key->user_id)->first();

                // Memeriksa apakah data pengguna ditemukan.
                if ($temp) {
                    $gambar = $temp->gambar;
                } else {
                    $gambar = null;
                }

                // Menyusun data siswa untuk ditampilkan.
                $data[] = [
                    'user_id' => $key['user_id'],
                    'name' => $key['name'],
                    'gambar' => $gambar,
                ];
            }

            // Menampilkan tampilan daftar siswa sebagai respons.
            return view('menu.profile.partials.siswaList', ['siswa' => $data])->render();
        } else {
            // Menampilkan halaman 404 jika parameter 'kelasName' null.
            abort(404);
        }
    }
}
