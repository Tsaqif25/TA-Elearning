@extends('layout.template.mainTemplate')

@section('title', 'Analytics Wakur')

@section('container')
<div class="flex flex-col w-full px-8 pt-8 pb-12 bg-[#F9FAFB] min-h-screen font-poppins">

  <h1 class="text-2xl font-extrabold text-[#0A090B] mb-6">Analytics</h1>
  <p class="text-sm text-[#7F8190] mb-8">Pemantauan aktivitas guru dan kelengkapan materi</p>

  <!-- Statistik -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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

  <!-- Grafik Aktivitas Mingguan -->
  <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
    <h2 class="text-lg font-bold text-[#0A090B] mb-3">Aktivitas Upload Minggu Ini</h2>
    <canvas id="uploadChart"></canvas>
  </div>
</div>

<!-- Tabel Materi Per Guru -->

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 mt-8">
  <h2 class="text-lg font-bold text-[#0A090B] mb-4">Materi Per Guru</h2>

  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-xl overflow-hidden">
      <thead class="bg-[#F9FAFB] text-[#7F8190] text-sm">
        <tr>
          <th class="px-4 py-3 text-center font-semibold w-[60px]">No</th>
          <th class="px-4 py-3 text-left font-semibold">Nama Guru</th>
          <th class="px-4 py-3 text-center font-semibold w-[160px]">Jumlah Upload</th>
          <th class="px-4 py-3 text-center font-semibold w-[200px]">Terakhir Upload</th>
        </tr>
      </thead>

      <tbody class="text-[#0A090B] divide-y divide-gray-100 text-sm">
        @foreach ($materiPerGuru as $index => $guru)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $index + 1 }}</td>
            <td class="px-4 py-3 font-semibold">{{ $guru->nama_guru }}</td>
            <td class="px-4 py-3 text-center font-bold text-[#2B82FE]">{{ $guru->total_upload }}</td>
            <td class="px-4 py-3 text-center text-[#7F8190]">
              {{ $guru->terakhir_upload ? \Carbon\Carbon::parse($guru->terakhir_upload)->translatedFormat('d F Y') : '-' }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>



<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('uploadChart').getContext('2d');
const data = {
  labels: {!! json_encode(array_column($dataGrafik, 'hari')) !!},
  datasets: [{
    label: 'Upload Materi',
    data: {!! json_encode(array_column($dataGrafik, 'total')) !!},
    borderColor: '#2B82FE',
    backgroundColor: 'rgba(43,130,254,0.1)',
    borderWidth: 2,
    tension: 0.4,
    fill: true,
    pointRadius: 5,
    pointHoverRadius: 7,
  }]
};
new Chart(ctx, {
  type: 'line',
  data: data,
  options: {
    scales: {
      y: { beginAtZero: true }
    },
    plugins: {
      legend: { display: false }
    }
  }
});
</script>
@endsection
