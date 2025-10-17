
   

  <div id="materi" class="tab-content ">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-[#0A090B]">Materi Pembelajaran</h2>
    <a href="{{ route('materi.create', $kelasMapel->id) }}" 
       class="bg-[#6C63FF] text-white px-6 py-2 rounded-full font-semibold shadow hover:bg-[#574FFB] transition">
      + Tambah Materi
    </a>
  </div>

  {{-- Grid Card --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  @forelse($materi as $materis)
    <div class="bg-white border-2 border-black rounded-2xl p-6 flex flex-col justify-between hover:shadow-md transition">
      {{-- Bagian Atas --}}
      <div>
        <div class="flex justify-between items-start mb-4">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-[#EDEBFE] flex items-center justify-center rounded-full">
              <i class="fa-solid fa-book text-[#6C63FF] text-lg"></i>
            </div>
            <h3 class="font-semibold text-lg text-[#0A090B] leading-tight">
              {{ $materis->name }}
            </h3>
          </div>

          {{-- 🔹 Tombol Hapus --}}
<form action="{{ route('materi.destroy', $materis->id) }}" method="POST" onsubmit="event.preventDefault(); handleDeleteMateri(this);" class="inline">
            @method('DELETE')
            <button type="submit"
                    class="text-gray-400 hover:text-red-500 transition"
                    title="Hapus Materi">
              <i class="fa-solid fa-trash text-sm"></i>
            </button>
          </form>
        </div>

        {{-- Tanggal --}}
        <p class="text-sm text-[#7F8190] flex items-center gap-2">
          <i class="fa-solid fa-calendar-days text-[#6C63FF]"></i>
          {{ $materis->created_at->format('d/m/Y') }}
        </p>
      </div>

      {{-- Bagian Bawah (Tombol) --}}
      <div class="flex gap-2 mt-5">
        <a href="{{ route('materi.edit', $materis->id) }}"
          class="flex-1 text-center px-4 py-1.5 border-1 border-[#0A090B] rounded-full text-sm font-semibold text-[#0A090B] hover:bg-[#F3F3F3] transition">
          Edit
        </a>
        <a href="{{ route('materi.show', $materis->id) }}"
          class="flex-1 text-center px-4 py-1.5 border-1 bg-[#6C63FF] text-white rounded-full text-sm font-semibold hover:bg-[#574FFB] transition">
          Lihat
        </a>
      </div>
    </div>
  @empty
    <div class="col-span-3">
      <div class="bg-gray-50 border border-dashed border-gray-300 rounded-2xl py-10 text-center text-gray-500">
        Belum ada materi di kelas ini.
      </div>
    </div>
  @endforelse
</div>


</div>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
function handleDeleteMateri(form) {
// Tampilkan konfirmasi kecil menggunakan Toastify
Toastify({
text: "Klik lagi untuk konfirmasi hapus materi!",
duration: 2000,
close: true,
gravity: "top",
position: "right",
style: { background: "#f59e0b" }
}).showToast();


// Ubah event agar klik berikutnya benar-benar hapus
form.onsubmit = function (e) {
e.preventDefault();


const formData = new FormData(form);
fetch(form.action, {
method: 'POST',
body: formData,
headers: {
'X-Requested-With': 'XMLHttpRequest',
'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
}
})
.then(response => {
if (response.ok) {
Toastify({
text: "Materi berhasil dihapus!",
duration: 1500,
close: false,
gravity: "top",
position: "right",
style: { background: "#16a34a" }
}).showToast();


setTimeout(() => window.location.reload(), 1500);
} else {
Toastify({
text: "Gagal menghapus materi.",
duration: 2000,
close: true,
gravity: "top",
position: "right",
style: { background: "#dc2626" }
}).showToast();
}
});
};
}
</script>
  