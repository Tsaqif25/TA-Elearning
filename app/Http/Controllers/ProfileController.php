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
            $profile = DataSiswa::where('user_id',$user->id);
        }

        else if ($user->hasRole('Pengajar')){
            $profile = guru::where('user_id',$user->id);
        }
        return view('menu.profile.edit',compact('profile','user'));
    }
}
