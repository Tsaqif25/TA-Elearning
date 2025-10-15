protected function authenticated($request, $user)
{
    if ($user->hasRole('Admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('Pengajar')) {
        return redirect()->route('pengajar.dashboard');
    } elseif ($user->hasRole('Siswa')) {
        return redirect()->route('home');
    }
    return redirect()->route('login')->with('error', 'Role tidak ditemukan');
}
