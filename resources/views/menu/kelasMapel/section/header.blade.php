<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
  <div class="bg-gradient-to-tr from-blue-500 to-green-500 text-white rounded-2xl p-6 shadow-lg">
    <h2 class="text-3xl font-bold mb-1">{{ $kelas->name }} - {{ $mapel->name }}</h2>
    <p class="text-sm text-white/90 mb-6">Kelola Materi, Tugas, dan Quiz di kelas ini</p>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="bg-white/20 rounded-lg p-4 text-center backdrop-blur-sm">
        <div class="text-xl font-bold">{{ $materi->count() }}</div>
        <div class="text-sm">Total Materi</div>
      </div>
      <div class="bg-white/20 rounded-lg p-4 text-center backdrop-blur-sm">
        <div class="text-xl font-bold">{{ $tugas->count() }}</div>
        <div class="text-sm">Total Tugas</div>
      </div>
      <div class="bg-white/20 rounded-lg p-4 text-center backdrop-blur-sm">
        <div class="text-xl font-bold">{{ $ujian->count() }}</div>
        <div class="text-sm">Total Ujian</div>
      </div>
    </div>
  </div>
</div>
