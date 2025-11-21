@extends('layout.template.mainTemplate')

@section('container')

<div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
  <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

      <!--  HEADER GRADIENT -->
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

          <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
              Detail Ujian
          </h1>
          <p class="text-sm opacity-90 mt-1">{{ $ujian->judul }}</p>
      </div>


      <!--  DETAIL UJIAN CARD -->
      <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8 mb-8">

          <h2 class="text-lg font-bold text-[#0A090B] flex items-center gap-2 mb-4">
              <i class="fa-solid fa-pen-to-square"></i> Informasi Ujian
          </h2>

          <div class="border border-gray-200 rounded-xl overflow-hidden">
              <table class="w-full text-sm">
                  <tbody>
                      <tr class="border-b">
                          <td class="bg-gray-50 font-semibold p-3 w-1/3">Nama Ujian</td>
                          <td class="p-3">{{ $ujian->judul }}</td>
                      </tr>
                      <tr class="border-b">
                          <td class="bg-gray-50 font-semibold p-3">Mata Pelajaran</td>
                          <td class="p-3">{{ $mapel->name }}</td>
                      </tr>
                      <tr class="border-b">
                          <td class="bg-gray-50 font-semibold p-3">Kelas</td>
                          <td class="p-3">{{ $kelas->name }}</td>
                      </tr>
                      <tr class="border-b">
                          <td class="bg-gray-50 font-semibold p-3">Jumlah Soal</td>
                          <td class="p-3">{{ $soal->count() }}</td>
                      </tr>
                      <tr>
                          <td class="bg-gray-50 font-semibold p-3">Durasi</td>
                          <td class="p-3">{{ $ujian->durasi_menit }} menit</td>
                      </tr>
                  </tbody>
              </table>
          </div>

      </div>

      <!--  SOAL UJIAN -->
      <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8">

          <h2 class="text-lg font-bold text-[#0A090B] flex items-center gap-2 mb-6">
              <i class="fa-solid fa-circle-question"></i> Daftar Soal Ujian
          </h2>

          <!-- TOMBOL -->
          <div class="flex flex-wrap gap-2 mb-6">
              <a href="{{ route('ujian.soal.create', $ujian->id) }}"
                  class="flex items-center gap-2 px-4 py-2 rounded-full bg-[#2B82FE] text-white text-sm font-semibold shadow hover:scale-[1.03] hover:shadow-lg transition">
                  <i class="fa-solid fa-plus"></i> Tambah Soal
              </a>

              <a href="{{ route('ujian.soal.importView', $ujian->id) }}"
                  class="flex items-center gap-2 px-4 py-2 rounded-full bg-green-600 text-white text-sm font-semibold shadow hover:bg-green-700">
                  <i class="fa-solid fa-file-excel"></i>
                  Import Soal
              </a>
          </div>

          <!-- LIST SOAL -->
          @if ($soal->isEmpty())
              <div class="flex flex-col items-center justify-center py-10 text-center">
                  <div class="w-14 h-14 flex items-center justify-center bg-[#EEF4FF] rounded-2xl text-[#2B82FE] mb-4 shadow-sm">
                      <i class="fa-solid fa-circle-question text-xl"></i>
                  </div>
                  <p class="text-[#7F8190] text-sm">Belum ada soal ditambahkan.</p>
              </div>
          @else

          <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
              <table class="w-full text-sm">
                  <thead class="bg-gray-50 border-b">
                      <tr class="text-[#7F8190] uppercase text-xs font-semibold">
                          <th class="p-3 text-center w-16">No.</th>
                          <th class="p-3 text-left">Soal</th>
                          <th class="p-3 w-40 text-center">Aksi</th>
                      </tr>
                  </thead>

                  <tbody class="divide-y divide-gray-100">
                      @foreach ($soal as $item)
                          <tr class="hover:bg-gray-50 transition">
                              <td class="p-3 text-center font-semibold">{{ $loop->iteration }}</td>
                              <td class="p-3 text-gray-800">
                                  {{ $item->pertanyaan }}
                              </td>
                              <td class="p-3 text-center flex justify-center gap-2">

                                  <!-- EDIT -->
                                  <a href="{{ route('ujian.soal.edit', [$ujian->id, $item->id]) }}"
                                      class="px-3 py-1.5 text-xs bg-amber-50 text-amber-700 rounded-full border border-amber-200 hover:bg-amber-100">
                                      Edit
                                  </a>

                                  <!-- DELETE -->
                                  <form action="{{ route('ujian.soal.destroy', [$ujian->id, $item->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                      @csrf
                                      @method('DELETE')
                                      <button
                                          class="px-3 py-1.5 text-xs bg-rose-50 text-rose-700 rounded-full border border-rose-200 hover:bg-rose-100">
                                          Hapus
                                      </button>
                                  </form>

                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>

          @endif

      </div>

  </div>
</div>

@endsection
