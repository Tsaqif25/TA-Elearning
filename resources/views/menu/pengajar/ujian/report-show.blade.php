@extends('layout.template.mainTemplate')

@section('container')

<div class="flex flex-col w-full bg-[#FAFAFA] min-h-screen font-poppins">
  <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

      <!-- 🔹 HEADER GRADIENT + BACK -->
      <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 sm:p-8 shadow-lg mb-8">

          <!-- Tombol Back -->
          <a href="{{ route('viewKelasMapel', [
              'mapel' => $kelasMapel->mapel->id,
              'kelas' => $kelasMapel->kelas->id,
              'tab' => 'quiz'
          ]) }}"
          class="flex items-center gap-2 text-white/90 hover:text-white font-medium text-sm mb-4 transition">
              <i class="fa-solid fa-arrow-left text-xs"></i>
              Kembali ke Daftar Quiz
          </a>

          <!-- Title -->
          <h2 class="text-2xl sm:text-3xl font-extrabold leading-tight">Nilai Siswa</h2>
          <p class="text-sm opacity-90 mt-1">{{ $ujian->judul }}</p>
      </div>

      <!-- 🔸 BODY UTAMA (CARD PUTIH) -->
      <div class="bg-white p-6 sm:p-8 rounded-2xl shadow border border-gray-200">

          <!-- Statistik -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

              <!-- Total Siswa -->
              <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-5">
                  <p class="text-gray-500 text-sm">Total Siswa</p>
                  <p class="text-3xl font-bold text-blue-600">{{ $attempts->count() }}</p>
              </div>

              <!-- Rata-rata -->
              <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-5">
                  <p class="text-gray-500 text-sm">Nilai Rata-rata</p>
                  <p class="text-3xl font-bold text-blue-600">
                      {{ round($attempts->avg('nilai'), 2) }}
                  </p>
              </div>

              <!-- Kelulusan -->
              @php
                  $min = $ujian->nilai_minimum ?? 75;
                  $lulus = $attempts->where('nilai', '>=', $min)->count();
                  $total = $attempts->count();
                  $percent = $total > 0 ? round(($lulus / $total) * 100) : 0;
              @endphp

              <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-5">
                  <p class="text-gray-500 text-sm">Tingkat Kelulusan</p>
                  <p class="text-3xl font-bold text-green-600">{{ $percent }}%</p>
                  <p class="text-gray-500 text-xs mt-1">({{ $lulus }}/{{ $total }})</p>
              </div>

          </div>

          <!-- HEADER TABEL -->
          <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-semibold">Daftar Nilai Siswa</h3>

              <a href="#"
                class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-full flex items-center gap-2 shadow transition">
                  <i class="fa-solid fa-file-csv"></i>
                  Export CSV
              </a>
          </div>

          <!-- TABEL -->
          <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">

              <table class="w-full text-sm">
                  <thead class="bg-gray-50 border-b">
                      <tr>
                          <th class="px-4 py-3 text-left">No</th>
                          <th class="px-4 py-3 text-left">Nama Siswa</th>
                          <th class="px-4 py-3 text-left">NIS/NIM</th>
                          <th class="px-4 py-3 text-center">Nilai</th>
                          <th class="px-4 py-3 text-left">Tanggal</th>
                      </tr>
                  </thead>

                  <tbody>
                      @foreach($attempts as $i => $a)
                      <tr class="border-b hover:bg-gray-50 transition">
                          <td class="px-4 py-3">{{ $i + 1 }}</td>
                          <td class="px-4 py-3 font-semibold">{{ $a->siswa->name }}</td>
                          <td class="px-4 py-3">{{ $a->siswa->nis }}</td>

                          <td class="px-4 py-3 text-center font-bold
                              {{ $a->nilai >= ($ujian->nilai_minimum ?? 75) ? 'text-green-600' : 'text-red-600' }}">
                              {{ $a->nilai }}
                          </td>

                          <td class="px-4 py-3">
                              {{ \Carbon\Carbon::parse($a->selesai)->translatedFormat('d F Y') }}
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>

          </div>

      </div>
  </div>
</div>

@endsection
