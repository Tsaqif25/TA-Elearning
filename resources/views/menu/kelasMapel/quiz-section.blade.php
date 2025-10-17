<div id="quiz" class="tab-content hidden">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-[#0A090B]">Quiz & Ujian</h2>
      {{-- <button class="bg-[#6C63FF] text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-[#574FFB] transition"></button> --}}
       <a href="{{ route('ujian.manage', [$kelas->id,$mapel->id]) }}" 
       class="bg-[#6C63FF] text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-[#574FFB] transition">
      + Buat Quiz
    </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white border border-[#DCDCDC] rounded-2xl p-5 hover:shadow-md transition">
        <div class="flex justify-between items-start mb-3">
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-[#EDEBFE] flex items-center justify-center rounded-full">
              <i class="fa-solid fa-file-lines text-[#6C63FF]"></i>
            </div>
            <h3 class="font-semibold text-lg">Quiz Persamaan Kuadrat</h3>
          </div>
          <span class="text-xs bg-[#EDEBFE] text-[#6C63FF] px-3 py-1 rounded-md font-medium">Terjadwal</span>
        </div>
        <p class="text-sm text-[#7F8190]">📅 22/10/2025</p>
        <p class="text-sm text-[#7F8190]">⏱️ 60 menit</p>
        <p class="text-sm text-[#7F8190]">👥 30 siswa</p>
        <div class="flex gap-2 mt-3">
          <button class="px-5 py-2 border border-[#0A090B] rounded-full text-sm font-semibold hover:bg-[#F3F3F3] transition">Edit</button>
          <button class="px-5 py-2 bg-[#6C63FF] text-white rounded-full text-sm font-semibold hover:bg-[#574FFB] transition">Detail</button>
        </div>
      </div>
    </div>
  </div>