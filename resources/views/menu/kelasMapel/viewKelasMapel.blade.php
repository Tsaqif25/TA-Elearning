@extends('layout.template.mainTemplate')

@section('container')

    {{-- Navigasi Breadcrumb --}}
    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $mapel['name'] }}</li>
            </ol>
        </nav>
    </div>

    {{-- Judul Halaman --}}
    <div class="ps-4 pe-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="display-6 fw-bold ">
                <a href="{{ route('dashboard') }}">
                    <button type="button" class="btn btn-outline-dark rounded-circle">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </a> {{ $mapel['name'] }}
                <span class="badge badge-secondary">{{ $kelas['name'] }}</span>
            </h1>
        </div>
    </div>

    {{-- Pesan Sukses --}}
    @if (session()->has('success'))
        <div class="alert alert-lg alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    

<!-- Template Kelas Mapel Page (Materi / Tugas / Quiz) dengan Laravel Blade dan Tailwind -->
<div class="flex flex-col w-full p-6">
  <!-- Header Kelas -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-bold text-[#0A090B]">Kelas 10 IPA 1</h1>
      <p class="text-[#7F8190] text-sm">👥 32 Siswa</p>
    </div>
    <a href="#" class="flex items-center gap-2 px-4 py-2 border rounded-full text-sm font-semibold text-[#0A090B] border-[#EEEEEE]">
      <i class="fa-regular fa-user"></i> Lihat Siswa
    </a>
  </div>

  <!-- Mini Navbar -->
  <div class="flex gap-3 bg-[#F9FAFB] p-2 rounded-full mb-8 w-fit">
    <button class="tab-link px-6 py-2 rounded-full font-semibold bg-white shadow text-[#0A090B]" data-target="#materi">Materi</button>
    <button class="tab-link px-6 py-2 rounded-full font-semibold text-[#7F8190] hover:bg-white" data-target="#tugas">Tugas</button>
    <button class="tab-link px-6 py-2 rounded-full font-semibold text-[#7F8190] hover:bg-white" data-target="#quiz">Quiz</button>
  </div>

  <!-- Section Materi -->
  <div id="materi" class="tab-content">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-[#0A090B]">Materi Pembelajaran</h2>
      <button class="bg-[#2B82FE] text-white px-4 py-2 rounded-lg font-semibold text-sm">+ Tambah Materi</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
      <div class="border border-[#EEEEEE] rounded-xl p-5 bg-white">
        <div class="flex justify-between items-start mb-3">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-[#E9F1FF] flex items-center justify-center rounded-full">
              <i class="fa-solid fa-book text-[#2B82FE]"></i>
            </div>
            <h3 class="font-semibold">Persamaan Kuadrat</h3>
          </div>
          <span class="text-xs bg-[#F3F4F6] px-2 py-1 rounded-md font-medium">PDF</span>
        </div>
        <p class="text-sm text-[#7F8190] mb-2"><i class="fa-regular fa-calendar"></i> 10/10/2025</p>
        <p class="text-sm text-[#7F8190] mb-3"><i class="fa-regular fa-eye"></i> 28 views</p>
        <div class="flex gap-2">
          <button class="px-4 py-2 bg-[#F3F4F6] rounded-lg font-semibold text-sm">Edit</button>
          <button class="px-4 py-2 bg-[#2B82FE] text-white rounded-lg font-semibold text-sm">Lihat</button>
        </div>
      </div>

      <div class="border border-[#EEEEEE] rounded-xl p-5 bg-white">
        <div class="flex justify-between items-start mb-3">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-[#E9F1FF] flex items-center justify-center rounded-full">
              <i class="fa-solid fa-book text-[#2B82FE]"></i>
            </div>
            <h3 class="font-semibold">Fungsi Trigonometri</h3>
          </div>
          <span class="text-xs bg-[#F3F4F6] px-2 py-1 rounded-md font-medium">Video</span>
        </div>
        <p class="text-sm text-[#7F8190] mb-2"><i class="fa-regular fa-calendar"></i> 08/10/2025</p>
        <p class="text-sm text-[#7F8190] mb-3"><i class="fa-regular fa-eye"></i> 32 views</p>
        <div class="flex gap-2">
          <button class="px-4 py-2 bg-[#F3F4F6] rounded-lg font-semibold text-sm">Edit</button>
          <button class="px-4 py-2 bg-[#2B82FE] text-white rounded-lg font-semibold text-sm">Lihat</button>
        </div>
      </div>

      <div class="border border-[#EEEEEE] rounded-xl p-5 bg-white">
        <div class="flex justify-between items-start mb-3">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-[#E9F1FF] flex items-center justify-center rounded-full">
              <i class="fa-solid fa-book text-[#2B82FE]"></i>
            </div>
            <h3 class="font-semibold">Logaritma</h3>
          </div>
          <span class="text-xs bg-[#F3F4F6] px-2 py-1 rounded-md font-medium">PDF</span>
        </div>
        <p class="text-sm text-[#7F8190] mb-2"><i class="fa-regular fa-calendar"></i> 05/10/2025</p>
        <p class="text-sm text-[#7F8190] mb-3"><i class="fa-regular fa-eye"></i> 30 views</p>
        <div class="flex gap-2">
          <button class="px-4 py-2 bg-[#F3F4F6] rounded-lg font-semibold text-sm">Edit</button>
          <button class="px-4 py-2 bg-[#2B82FE] text-white rounded-lg font-semibold text-sm">Lihat</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Section Tugas -->
  <div id="tugas" class="tab-content hidden">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-[#0A090B]">Tugas</h2>
      <button class="bg-[#2B82FE] text-white px-4 py-2 rounded-lg font-semibold text-sm">+ Buat Tugas</button>
    </div>

    <div class="space-y-4">
      <div class="border border-[#EEEEEE] rounded-xl p-5 bg-white flex justify-between items-start">
        <div>
          <h3 class="font-semibold">Latihan Persamaan Kuadrat <span class="text-xs bg-[#2B82FE] text-white px-2 py-1 rounded-md">Aktif</span></h3>
          <p class="text-sm text-[#7F8190] mt-1"><i class="fa-regular fa-calendar"></i> Deadline: 20/10/2025</p>
          <div class="flex gap-2 mt-3">
            <button class="px-4 py-2 bg-[#F3F4F6] rounded-lg font-semibold text-sm">Lihat Pengumpulan</button>
            <button class="px-4 py-2 bg-[#F3F4F6] rounded-lg font-semibold text-sm">Edit</button>
          </div>
        </div>
        <div class="text-right">
          <p class="text-lg font-semibold">20/32</p>
          <p class="text-sm text-[#7F8190]">Sudah mengumpulkan</p>
        </div>
      </div>

      <div class="border border-[#EEEEEE] rounded-xl p-5 bg-white flex justify-between items-start">
        <div>
          <h3 class="font-semibold">Tugas Trigonometri <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded-md">Selesai</span></h3>
          <p class="text-sm text-[#7F8190] mt-1"><i class="fa-regular fa-calendar"></i> Deadline: 18/10/2025</p>
          <div class="flex gap-2 mt-3">
            <button class="px-4 py-2 bg-[#F3F4F6] rounded-lg font-semibold text-sm">Lihat Pengumpulan</button>
            <button class="px-4 py-2 bg-[#F3F4F6] rounded-lg font-semibold text-sm">Edit</button>
          </div>
        </div>
        <div class="text-right">
          <p class="text-lg font-semibold">32/32</p>
          <p class="text-sm text-[#7F8190]">Sudah mengumpulkan</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Section Quiz -->
  <div id="quiz" class="tab-content hidden">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-[#0A090B]">Quiz & Ujian</h2>
      <button class="bg-[#2B82FE] text-white px-4 py-2 rounded-lg font-semibold text-sm">+ Buat Quiz</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="border border-[#EEEEEE] rounded-xl p-5 bg-white">
        <div class="flex justify-between items-start mb-3">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-[#E9F1FF] flex items-center justify-center rounded-full">
              <i class="fa-solid fa-file-lines text-[#2B82FE]"></i>
            </div>
            <h3 class="font-semibold">Quiz Persamaan Kuadrat</h3>
          </div>
          <span class="text-xs bg-[#E9F1FF] text-[#2B82FE] px-2 py-1 rounded-md font-medium">Terjadwal</span>
        </div>
        <p class="text-sm text-[#7F8190]"><i class="fa-regular fa-calendar"></i> 22/10/2025</p>
        <p class="text-sm text-[#7F8190]"><i class="fa-regular fa-clock"></i> 60 menit</p>
        <p class="text-sm text-[#7F8190]"><i class="fa-regular fa-user"></i> 30 siswa</p>
        <div class="flex gap-2 mt-3">
          <button class="px-4 py-2 bg-[#F3F4F6] rounded-lg font-semibold text-sm">Edit</button>
          <button class="px-4 py-2 bg-[#2B82FE] text-white rounded-lg font-semibold text-sm">Detail</button>
        </div>
      </div>

      <div class="border border-[#EEEEEE] rounded-xl p-5 bg-white">
        <div class="flex justify-between items-start mb-3">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-[#E9F1FF] flex items-center justify-center rounded-full">
              <i class="fa-solid fa-file-lines text-[#2B82FE]"></i>
            </div>
            <h3 class="font-semibold">Ulangan Harian 1</h3>
          </div>
          <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-md font-medium">Selesai</span>
        </div>
        <p class="text-sm text-[#7F8190]"><i class="fa-regular fa-calendar"></i> 15/10/2025</p>
        <p class="text-sm text-[#7F8190]"><i class="fa-regular fa-clock"></i> 90 menit</p>
        <p class="text-sm text-[#7F8190]"><i class="fa-regular fa-user"></i> 32 siswa</p>
        <div class="flex gap-2 mt-3">
          <button class="px-4 py-2 bg-[#F3F4F6] rounded-lg font-semibold text-sm">Edit</button>
          <button class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold text-sm">Lihat Hasil</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const tabs = document.querySelectorAll('.tab-link');
  const contents = document.querySelectorAll('.tab-content');
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(btn => btn.classList.remove('bg-white', 'shadow', 'text-[#0A090B]'));
      tabs.forEach(btn => btn.classList.add('text-[#7F8190]'));
      tab.classList.add('bg-white', 'shadow', 'text-[#0A090B]');
      contents.forEach(content => content.classList.add('hidden'));
      document.querySelector(tab.getAttribute('data-target')).classList.remove('hidden');
    });
  });
</script>

<script>
  const tabs = document.querySelectorAll('.tab-link');
  const contents = document.querySelectorAll('.tab-content');
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(btn => btn.classList.remove('bg-white', 'shadow', 'text-[#0A090B]'));
      tabs.forEach(btn => btn.classList.add('text-[#7F8190]'));
      tab.classList.add('bg-white', 'shadow', 'text-[#0A090B]');
      contents.forEach(content => content.classList.add('hidden'));
      document.querySelector(tab.getAttribute('data-target')).classList.remove('hidden');
    });
  });
</script>

    <div class="modal fade" id="modalHapusMateri" tabindex="-1" aria-labelledby="modalHapusMateriLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusMateriLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Materi ini?
                </div>
                <div class="modal-footer">
                    <form id="formDeleteMateri" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


   
    <div class="modal fade" id="modalHapusPengumuman" tabindex="-1" aria-labelledby="modalHapusPengumumanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusPengumumanLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Pengumuman ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('destroyPengumuman') }}" method="post">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <input type="hidden" name="hapusId" id="pengumumanId" value="">
                        <input type="hidden" name="kelasMapelId" id="kelasMapelPengumuman" value="">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus Ujian --}}
    <div class="modal fade" id="modalHapusUjian" tabindex="-1" aria-labelledby="modalHapusUjianLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusUjianLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Ujian ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('ujian.destroy') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <input type="hidden" name="hapusId" id="ujianId" value="">
                        <input type="hidden" name="tipe" id="tipe" value="">
                        <input type="hidden" name="kelasMapelId" id="kelasMapelUjian" value="">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Hapus --}}



    <script>
        function changeValueTugas(id) {
            document.getElementById('idTugas').value = id;
        }

        function changeValueMateri(itemId) {
            console.log(itemId);
            const materiId = document.getElementById('materiId');
            const kelasMapelMateri = document.getElementById('kelasMapelMateri');
            materiId.setAttribute('value', itemId);
            kelasMapelMateri.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }

        // function changeValueDiskusi(itemId) {
        //     console.log(itemId);
        //     const diskusiId = document.getElementById('diskusiId');
        //     const kelasMapelDiskusi = document.getElementById('kelasMapelDiskusi');
        //     diskusiId.setAttribute('value', itemId);
        //     kelasMapelDiskusi.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        // }

        function changeValuePengumuman(itemId) {
            console.log(itemId);
            const pengumumanId = document.getElementById('pengumumanId');
            const kelasMapelPengumuman = document.getElementById('kelasMapelPengumuman');
            pengumumanId.setAttribute('value', itemId);
            kelasMapelPengumuman.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }

        function changeValueTugas(itemId) {
            console.log(itemId);
            const tugasId = document.getElementById('tugasId');
            const kelasMapelTugas = document.getElementById('kelasMapelTugas');
            tugasId.setAttribute('value', itemId);
            kelasMapelTugas.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }

        function changeValueUjian(itemId, tipe) {
            console.log(itemId);
            console.log(tipe);
            const ujianId = document.getElementById('ujianId');
            const tipeId = document.getElementById('tipe');
            const kelasMapelUjian = document.getElementById('kelasMapelUjian');
            ujianId.setAttribute('value', itemId);
            tipeId.setAttribute('value', tipe);
            kelasMapelUjian.setAttribute('value', "{{ $kelasMapel->id ?? '' }}");
        }
    </script>
@endsection

{{-- Script JavaScript --}}
