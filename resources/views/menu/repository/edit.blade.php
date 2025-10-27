@extends('layout.template.mainTemplate')

@section('container')
    <div class="flex flex-col w-full bg-[#FAFAFA] font-poppins min-h-screen">
        <div class="max-w-[1200px] w-full mx-auto px-5 sm:px-6 lg:px-10 mt-8 mb-16">

            <!-- 🔹 Tombol Back -->
            <a href="{{ route('repository.index') }}"
                class="flex items-center gap-2 text-[#2B82FE] hover:text-[#1a5fd4] font-medium text-sm mb-6 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Kembali ke Repository
            </a>

            <!-- 🔸 Header -->
            <div
                class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-8 flex items-start sm:items-center justify-between flex-wrap gap-4">
                <div class="flex items-start sm:items-center gap-3">
                    <div class="w-1.5 h-8 rounded-full bg-[#2B82FE]"></div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0A090B] leading-tight">
                            Edit Repository — {{ $repository->judul }}
                        </h1>
                        <p class="text-sm text-[#7F8190]">Perbarui informasi atau file repository Anda</p>
                    </div>
                </div>

                <div
                    class="flex items-center gap-2 bg-[#E8F0FF] text-[#2B82FE] px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit Repository
                </div>
            </div>

            <!-- 🔸 Card Form Utama -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 flex flex-col lg:flex-row gap-6">

                <!-- Kolom Kiri (Form) -->
                <div class="flex-1">
                    <form id="formRepositoryEdit" action="{{ route('repository.update', $repository->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <!-- Judul -->
                        <div>
                            <label for="judul" class="block text-sm font-semibold text-gray-800 mb-2">
                                Judul Materi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="judul" name="judul"
                                value="{{ old('judul', $repository->judul) }}" placeholder="Masukkan judul materi..."
                                required
                                class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition placeholder:text-gray-400">
                        </div>

                        <!-- Kelas & Jurusan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Kelas</label>
                                <select name="kelas"
                                    class="w-full border border-gray-200 rounded-xl p-3 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20">
                                    <option value="">Pilih Kelas</option>
                                    <option value="10" {{ old('kelas', $repository->kelas) == '10' ? 'selected' : '' }}>
                                        Kelas 10</option>
                                    <option value="11" {{ old('kelas', $repository->kelas) == '11' ? 'selected' : '' }}>
                                        Kelas 11</option>
                                    <option value="12" {{ old('kelas', $repository->kelas) == '12' ? 'selected' : '' }}>
                                        Kelas 12</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Jurusan</label>
                                <select name="jurusan"
                                    class="w-full border border-gray-200 rounded-xl p-3 bg-gray-50 focus:border-[#2B82FE] focus:ring focus:ring-[#2B82FE]/20 transition">
                                    <option value="">Pilih Jurusan</option>
                                    <option value="PPLG"
                                        {{ old('jurusan', $repository->jurusan ?? '') == 'PPLG' ? 'selected' : '' }}>
                                        Pengembangan Perangkat Lunak dan Gim (PPLG)
                                    </option>
                                    <option value="TKJ"
                                        {{ old('jurusan', $repository->jurusan ?? '') == 'TKJ' ? 'selected' : '' }}>
                                        Teknik Komputer dan Jaringan (TKJ)
                                    </option>
                                    <option value="ULW"
                                        {{ old('jurusan', $repository->jurusan ?? '') == 'ULW' ? 'selected' : '' }}>
                                        Usaha Layanan Wisata (ULW)
                                    </option>
                                    <option value="MPLB"
                                        {{ old('jurusan', $repository->jurusan ?? '') == 'MPLB' ? 'selected' : '' }}>
                                        Manajemen Perkantoran dan Layanan Bisnis (MPLB)
                                    </option>
                                    <option value="AKL"
                                        {{ old('jurusan', $repository->jurusan ?? '') == 'AKL' ? 'selected' : '' }}>
                                        Akuntansi dan Keuangan Lembaga (AKL)
                                    </option>
                                    <option value="BDR"
                                        {{ old('jurusan', $repository->jurusan ?? '') == 'BDR' ? 'selected' : '' }}>
                                        Bisnis Digital dan Ritel (BDR)
                                    </option>
                                </select>



                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-semibold text-gray-800 mb-2">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="5" placeholder="Jelaskan isi materi repository..."
                                class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none placeholder:text-gray-400">{{ old('deskripsi', $repository->deskripsi) }}</textarea>
                        </div>

                        <!-- Link YouTube -->
                        <div>
                            <label for="youtube_link" class="block text-sm font-semibold text-gray-800 mb-2">Link YouTube
                                (Opsional)</label>
                            <textarea id="youtube_link" name="youtube_link" rows="4" placeholder="https://youtu.be/abcd1234"
                                class="w-full rounded-xl border border-gray-200 bg-[#F9FAFB] focus:border-[#2B82FE] focus:ring-2 focus:ring-[#2B82FE]/20 p-3 outline-none transition resize-none placeholder:text-gray-400">{{ old('youtube_link', $repository->youtube_link) }}</textarea>
                        </div>

                        <!-- Dropzone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Upload File Baru</label>
                            <div id="my-dropzone"
                                class="dropzone border-2 border-dashed border-gray-300 bg-[#F9FAFB] hover:bg-[#F3F6FF] rounded-xl p-10 text-center cursor-pointer transition">
                                <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#2B82FE] mb-3"></i>
                                <p class="text-sm text-[#7F8190] font-medium">Seret file ke sini atau klik untuk mengunggah
                                </p>
                                <p class="text-xs text-gray-400 mt-1">(PDF, DOCX, PPTX, ZIP, MP4, dsb. — maks 10 MB)</p>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="flex justify-end gap-3 mt-8">
                            <a href="{{ route('repository.index') }}"
                                class="px-5 py-2.5 rounded-full border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
                                Batal
                            </a>
                            <button type="submit" id="btnSimpanEdit"
                                class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-[#2B82FE] to-[#1a5fd4] text-white font-semibold shadow hover:opacity-90 transition">
                                <i class="fa-solid fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- 🔹 Kolom Kanan (File Lama) -->
                <div class="lg:w-[30%] bg-[#F9FAFB] border border-gray-200 rounded-2xl p-6 h-fit">
                    <h3 class="font-bold text-[#0A090B] mb-3 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-folder-open text-[#2B82FE]"></i> File Lama
                    </h3>

                    <div class="divide-y divide-gray-100">
                        @forelse ($repository->files as $file)
                            <div class="flex items-center justify-between py-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    @php
                                        $icon = 'fa-file';
                                        if (Str::endsWith($file->file, ['.pdf'])) {
                                            $icon = 'fa-file-pdf';
                                        } elseif (Str::endsWith($file->file, ['.doc', '.docx'])) {
                                            $icon = 'fa-file-word';
                                        } elseif (Str::endsWith($file->file, ['.ppt', '.pptx'])) {
                                            $icon = 'fa-file-powerpoint';
                                        } elseif (Str::endsWith($file->file, ['.xls', '.xlsx'])) {
                                            $icon = 'fa-file-excel';
                                        } elseif (Str::endsWith($file->file, ['.jpg', '.jpeg', '.png'])) {
                                            $icon = 'fa-image';
                                        } elseif (Str::endsWith($file->file, ['.mp4'])) {
                                            $icon = 'fa-video';
                                        }
                                    @endphp
                                    <i class="fa-solid {{ $icon }} text-[#2B82FE] text-lg flex-shrink-0"></i>
                                    <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
                                        class="text-sm text-gray-700 truncate hover:text-[#2B82FE] hover:underline min-w-0">
                                        {{ Str::limit($file->file, 60) }}
                                    </a>
                                </div>
                                <form action="{{ route('repository.destroyFile', $repository->id) }}" method="POST"
                                    onsubmit="event.preventDefault(); handleDeleteRepo(this);" class="ml-4 flex-shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="file_id" value="{{ $file->id }}">
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 text-rose-500 hover:text-rose-700 text-xs font-medium transition">
                                        <i class="fa-solid fa-trash"></i><span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm italic py-2">Belum ada file yang diunggah.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function handleDeleteRepo(form) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'File ini akan dihapus dari repository!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-lg',
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg mx-1 text-sm',
                    cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-lg mx-1 text-sm',
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire({
                        title: 'Terhapus!',
                        text: 'File berhasil dihapus.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }

        Dropzone.autoDiscover = false;
        const myDropzone = new Dropzone("#my-dropzone", {
            url: "/repository/{{ $repository->id }}/upload-file",
            paramName: "file",
            maxFilesize: 10,
            acceptedFiles: ".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,.mp4,.jpg,.png",
            addRemoveLinks: true,
            timeout: 60000,
            autoProcessQueue: false,
            parallelUploads: 100,
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        });

        myDropzone.on("queuecomplete", function() {
            Toastify({
                text: "Semua file berhasil diunggah!",
                duration: 1000,
                gravity: "top",
                position: "right",
                style: {
                    background: "#16a34a"
                }
            }).showToast();
            setTimeout(() => window.location.href = "{{ route('repository.index') }}", 1000);
        });

        $('#formRepositoryEdit').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    if (myDropzone.getQueuedFiles().length === 0) {
                        Toastify({
                            text: "Perubahan berhasil disimpan!",
                            duration: 1500,
                            gravity: "top",
                            position: "right",
                            style: {
                                background: "#16a34a"
                            }
                        }).showToast();
                        setTimeout(() => window.location.href = "{{ route('repository.index') }}",
                            1500);
                    } else {
                        myDropzone.processQueue();
                    }
                },
                error: function() {
                    Toastify({
                        text: "Terjadi kesalahan saat menyimpan perubahan.",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        style: {
                            background: "#dc2626"
                        }
                    }).showToast();
                }
            });
        });
    </script>
@endsection
