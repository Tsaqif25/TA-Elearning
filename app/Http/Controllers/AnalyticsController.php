<?php

namespace App\Http\Controllers ;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // 🔹 Periode (default: 30 hari terakhir)
        $startDate = now()->subDays(30);
        $endDate = now();

        // 🔹 Total upload bulan ini
        $totalUpload = Materi::whereBetween('created_at', [$startDate, $endDate])->count();

        // 🔹 Rata-rata upload per hari
        $days = $endDate->diffInDays($startDate);
        $rataUploadPerHari = $days > 0 ? round($totalUpload / $days, 0) : $totalUpload;

        // 🔹 Guru aktif (yang upload materi)
        $guruAktif = Materi::whereBetween('created_at', [$startDate, $endDate])
            ->select('user_id')
            ->distinct()
            ->count();

        // 🔹 Total materi keseluruhan
        $totalMateri = Materi::count();

        // 🔹 Data upload mingguan (untuk grafik)
        $uploadMingguan = Materi::select(
            DB::raw('DAYNAME(created_at) as hari'),
            DB::raw('COUNT(*) as total')
        )
        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        ->groupBy('hari')
        ->orderByRaw("FIELD(hari, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
        ->get();

        // 🔹 Siapkan data hari default (agar grafik selalu penuh)
        $hariDefault = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        $dataGrafik = [];
        foreach ($hariDefault as $hari) {
            $dataGrafik[] = [
                'hari' => $hari,
                'total' => $uploadMingguan->firstWhere('hari', $hari)->total ?? 0,
            ];
        }

$materiPerGuru = User::role('Pengajar')
    ->leftJoin('editor_accesses', 'users.id', '=', 'editor_accesses.user_id')
    ->leftJoin('kelas_mapels', 'editor_accesses.kelas_mapel_id', '=', 'kelas_mapels.id')
    ->leftJoin('materis', 'kelas_mapels.id', '=', 'materis.kelas_mapel_id')
    ->select(
        'users.name as nama_guru',
        DB::raw('COUNT(materis.id) as total_upload'),
        DB::raw('MAX(materis.created_at) as terakhir_upload')
    )
    ->groupBy('users.id', 'users.name')
    ->orderByDesc('total_upload')
    ->get();


        // 🔹 Kirim ke view
        return view('menu.wakur.analytics.analytics', [
            'totalUpload' => $totalUpload,
            'rataUploadPerHari' => $rataUploadPerHari,
            'guruAktif' => $guruAktif,
            'totalMateri' => $totalMateri,
            'dataGrafik' => $dataGrafik,
               'materiPerGuru' => $materiPerGuru,
        ]);
    }
}
