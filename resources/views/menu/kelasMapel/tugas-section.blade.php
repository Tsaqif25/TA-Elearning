  <div id="tugas" class="tab-content hidden ">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-[#0A090B]">Tugas</h2>
      {{-- <button class="bg-[#6C63FF] text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-[#574FFB] transition">+ Buat Tugas</button> --}}
       <a href="{{ route('viewCreateTugas', $kelasMapel->id) }}" 
       class="bg-[#6C63FF] text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-[#574FFB] transition">
      + Buat Tugas
    </a>
    </div>

<div class="space-y-5">
  @forelse($tugas as $tugass)
    <div class="bg-white border-2 border-black rounded-xl p-5 flex justify-between items-start">
      <div>
        <h3 class="font-semibold text-lg">
          {{ $tugass->name }}
          <span class="text-xs bg-[#6C63FF] text-white px-2 py-1 rounded-md font-medium">Aktif</span>
        </h3>
        <p class="text-sm text-[#7F8190] mt-1">
          📅 Deadline: {{ \Carbon\Carbon::parse($tugass->deadline ?? '2025-10-20')->format('d/m/Y') }}
        </p>

        <div class="flex gap-2 mt-3">
          <a href="{{ route('viewUpdateTugas',$tugass->id) }}"
             class="px-5 py-2 border border-[#0A090B] rounded-full text-sm font-semibold hover:bg-[#F3F3F3] transition">
             Edit
          </a>

           <a href="{{route('viewTugas',$tugass->id)}}"
             class="px-5 py-2 border text-white border-[#0A090B] rounded-full text-sm font-semibold bg-[#6C63FF] hover:bg-[#574FFB] transition">
             Lihat Pengumpulan
          </a>
        </div>
      </div>

      <div class="text-right">
        <p class="text-lg font-semibold">20/32</p>
        <p class="text-sm text-[#7F8190]">Sudah mengumpulkan</p>
      </div>
    </div>
  @empty
    <div class="bg-gray-50 border border-dashed border-gray-300 rounded-2xl py-10 text-center text-gray-500">
      Belum ada Tugas di kelas ini.
    </div>
  @endforelse
</div>


  </div>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>