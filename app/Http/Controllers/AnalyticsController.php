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

        // 🔹 Kirim ke view
        return view('wakur.analytics', [
            'totalUpload' => $totalUpload,
            'rataUploadPerHari' => $rataUploadPerHari,
            'guruAktif' => $guruAktif,
            'totalMateri' => $totalMateri,
            'dataGrafik' => $dataGrafik,
        ]);
    }
}
