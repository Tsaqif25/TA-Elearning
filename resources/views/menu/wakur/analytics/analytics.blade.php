@extends('layout.template.mainTemplate')

@section('title', 'Analytics Wakur')

@section('container')
<div class="flex flex-col w-full px-4 sm:px-6 lg:px-8 pt-8 pb-12 bg-[#F9FAFB] min-h-screen font-poppins">

  <h1 class="text-2xl font-extrabold text-[#0A090B] mb-2">Analytics</h1>
  <p class="text-sm text-[#7F8190] mb-8">Pemantauan aktivitas guru dan kelengkapan materi</p>

  {{-- Statistik Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
      <p class="text-sm text-[#7F8190]">Total Upload Bulan Ini</p>
      <h2 class="text-3xl font-extrabold text-[#0A090B]">{{ $totalUpload }}</h2>
    </div>
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
      <p class="text-sm text-[#7F8190]">Rata-rata Upload/Hari</p>
      <h2 class="text-3xl font-extrabold text-[#0A090B]">{{ $rataUploadPerHari }}</h2>
    </div>
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
      <p class="text-sm text-[#7F8190]">Guru Aktif</p>
      <h2 class="text-3xl font-extrabold text-[#0A090B]">{{ $guruAktif }}</h2>
    </div>
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
      <p class="text-sm text-[#7F8190]">Total Materi</p>
      <h2 class="text-3xl font-extrabold text-[#0A090B]">{{ $totalMateri }}</h2>
    </div>
  </div>

  {{-- Grafik dan Tabel responsif --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    {{-- Grafik Aktivitas Mingguan --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
      <h2 class="text-lg font-bold text-[#0A090B] mb-4 flex items-center gap-2">
        📊 Aktivitas Upload Minggu Ini
      </h2>
      <div class="w-full h-[300px] sm:h-[350px]">
        <canvas id="uploadChart" class="w-full h-full"></canvas>
      </div>
    </div>

    {{-- Materi Per Guru --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
      <h2 class="text-lg font-bold text-[#0A090B] mb-4 flex items-center gap-2">
        👨‍🏫 Materi Per Guru
      </h2>

      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-xl overflow-hidden text-sm">
          <thead class="bg-[#F9FAFB] text-[#7F8190]">
            <tr>
              <th class="px-4 py-3 text-center font-semibold w-[50px]">No</th>
              <th class="px-4 py-3 text-left font-semibold">Nama Guru</th>
              <th class="px-4 py-3 text-center font-semibold w-[140px]">Jumlah Upload</th>
            </tr>
          </thead>
          <tbody class="text-[#0A090B] divide-y divide-gray-100">
            @foreach ($materiPerGuru as $index => $guru)
              <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                <td class="px-4 py-3 font-semibold">{{ $guru->nama_guru }}</td>
                <td class="px-4 py-3 text-center font-bold text-[#2B82FE]">{{ $guru->total_upload }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6 text-center">
          {{ $materiPerGuru->links('pagination::tailwind') }}
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('uploadChart').getContext('2d');
const data = {
  labels: {!! json_encode(array_column($dataGrafik, 'hari')) !!},
  datasets: [{
    label: 'Upload Materi',
    data: {!! json_encode(array_column($dataGrafik, 'total')) !!},
    borderColor: '#2B82FE',
    backgroundColor: (ctx) => {
      const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
      gradient.addColorStop(0, 'rgba(43,130,254,0.25)');
      gradient.addColorStop(1, 'rgba(43,130,254,0)');
      return gradient;
    },
    borderWidth: 3,
    tension: 0.4,
    fill: true,
    pointRadius: 4,
    pointHoverRadius: 6,
  }]
};

new Chart(ctx, {
  type: 'line',
  data: data,
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: { beginAtZero: true, grid: { color: '#E9EAEB' } },
      x: { grid: { display: false } }
    },
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#2B82FE',
        titleColor: '#fff',
        bodyColor: '#fff',
        padding: 10,
        displayColors: false,
      }
    }
  }
});
</script>
@endsection
