<?php

namespace App\Http\Controllers;

use App\Models\guru;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit() 
    {
        $user = Auth::user();

        if ($user->hasRole('Siswa')) {
            $profile = DataSiswa::where('user_id',$user->id)->first();
        }

        else if ($user->hasRole('Pengajar')){
            $profile = guru::where('user_id',$user->id)->first();
        }
        return view('menu.profile.edit',compact('profile','user'));
    }

public function update(Request $request)
{
    $user = Auth::user();

    // validasi
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' .$user->id,
        'password' => 'nullable|min:6',
        'no_telp' => 'nullable|string',
    ]);

    // Update Table Users
    $user->name = $request->name;
    $user->email = $request->email ;

    if (!empty($request->password)) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    // Update Profile Siswa
    if ($user->hasRole('Siswa')) {
        $profile = DataSiswa::where('user_id',$user->id)->first();

        $profile->update([
            'no_telp' => $request->no_telp,
        ]);
    }

    if ($user->hasRole('Pengajar')){
        $profile = Guru::where('user_id',$user->id)->first();

        $profile->update([
            'no_telp' => $request->no_telp,
        ]);
    }

    return back()->with('success','Profile Berhasil Diperbarui');
}




}
