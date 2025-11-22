@extends('layout.template.mainTemplate')

@section('container')
    {{-- Navigasi Breadcrumb --}}
    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('viewKelasMapel', ['mapel' => $mapel->id, 'kelas' => $kelas->id]) }}">
                        {{ $mapel->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Ujian</li>
            </ol>
        </nav>
    </div>

    {{-- Judul Halaman --}}
    <div class="ps-4 pe-4 mt-4 pt-4">
        <h2 class="display-6 fw-bold">
            <a href="{{ route('viewKelasMapel', ['mapel' => $mapel->id, 'kelas' => $kelas->id]) }}">
                <button type="button" class="btn btn-outline-secondary rounded-circle">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </a>
            Tambah Ujian (Multiple Choice)
        </h2>
    </div>

    {{-- Formulir Tambah Ujian --}}
    <div class="row p-4">
        <div class="col-12">
            <form action="{{ route('createUjian') }}" method="POST">
                @csrf

                {{-- Hidden data --}}
                <input type="hidden" name="kelasId" value="{{ $kelas->id }}">
                <input type="hidden" name="mapelId" value="{{ $mapel->id }}">
                <input type="hidden" name="tipe" value="multiple">

                {{-- Nama Ujian --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Judul Ujian <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Inputkan judul ujian..." value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

              

                {{-- Deadline --}}
                <div class="mb-3">
                    <label for="due" class="form-label">Batas Waktu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="due" name="due"
                        placeholder="Pilih tanggal & waktu..." autocomplete="off" value="{{ old('due') }}" required>
                    @error('due')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Container Soal --}}
                <h4 class="fw-bold text-primary mt-4"><i class="fa-solid fa-pen"></i> Soal Pilihan Ganda</h4>
                <div id="containerPertanyaan">
                    {{-- Pertanyaan pertama default --}}
                    <div class="bg-white border rounded-2 p-4 mt-4 pertanyaan">
                        <h3>Soal <span class="badge bg-primary">1</span>
                            <button type="button" class="btn btn-outline-danger btnKurangi" style="display:none">X</button>
                        </h3>
                        <div class="mb-3 row">
                            <div class="col-lg-7 col-12">
                                <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="pertanyaan[]" rows="3" required></textarea>
                            </div>
                            <div class="col-lg-5 col-12 row">
                                <div class="col-6 mb-2">
                                    <label class="form-label">A <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="a[]" required>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">B <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="b[]" required>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">C <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="c[]" required>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">D (opsional)</label>
                                    <input type="text" class="form-control" name="d[]">
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">E (opsional)</label>
                                    <input type="text" class="form-control" name="e[]">
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label text-primary fw-bold">Jawaban</label>
                                    <select name="jawaban[]" class="form-select">
                                        <option value="a">A</option>
                                        <option value="b">B</option>
                                        <option value="c">C</option>
                                        <option value="d">D</option>
                                        <option value="e">E</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Tambah Pertanyaan --}}
                <div class="mt-3 mb-4">
                    <button type="button" class="btn btn-outline-success w-100 btn-lg" id="btnTambahPertanyaan">
                        Tambah Pertanyaan
                    </button>
                </div>

                {{-- Tombol Submit --}}
                <button type="submit" class="btn btn-lg btn-primary w-100">Simpan Ujian</button>
            </form>
        </div>
    </div>

    {{-- Script Dinamis --}}
    <script>
        $(document).ready(function() {
            // DateTime Picker
            $('#due').datetimepicker({
                format: 'Y-m-d H:i',
                locale: 'id'
            });

            // Tambah Pertanyaan Baru
            $('#btnTambahPertanyaan').click(function() {
                const jumlahPertanyaan = $('.pertanyaan').length;
                const nomor = jumlahPertanyaan + 1;

                const template = `
                <div class="bg-white border rounded-2 p-4 mt-4 pertanyaan">
                    <h3>Soal <span class="badge bg-primary">${nomor}</span>
                        <button type="button" class="btn btn-outline-danger btnKurangi">X</button>
                    </h3>
                    <div class="mb-3 row">
                        <div class="col-lg-7 col-12">
                            <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="pertanyaan[]" rows="3" required></textarea>
                        </div>
                        <div class="col-lg-5 col-12 row">
                            <div class="col-6 mb-2">
                                <label class="form-label">A <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="a[]" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">B <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="b[]" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">C <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="c[]" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">D (opsional)</label>
                                <input type="text" class="form-control" name="d[]">
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label">E (opsional)</label>
                                <input type="text" class="form-control" name="e[]">
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label text-primary fw-bold">Jawaban</label>
                                <select name="jawaban[]" class="form-select">
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                    <option value="d">D</option>
                                    <option value="e">E</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>`;

                $('#containerPertanyaan').append(template);
            });

            // Hapus Pertanyaan
            $('#containerPertanyaan').on('click', '.btnKurangi', function() {
                $(this).closest('.pertanyaan').remove();

                // Update nomor soal
                $('.pertanyaan').each(function(index) {
                    $(this).find('h3 span.badge').text(index + 1);
                });
            });
        });
    </script>
@endsection