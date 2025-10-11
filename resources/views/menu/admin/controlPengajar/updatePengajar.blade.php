@extends('layout.template.mainTemplate')

@section('container')

{{-- HEADER --}}
<div class="ps-4 pe-4 mt-4 pt-4">
    <h2 class="display-6 fw-bold">
        <a href="{{ route('viewPengajar') }}">
            <button type="button" class="btn btn-outline-secondary rounded-circle">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
        </a> 
        Update Pengajar
    </h2>
</div>

{{-- MAIN FORM --}}
<form action="{{ route('updatePengajar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row p-4">
        {{-- FORM DATA PENGAJAR --}}
        <div class="col-12 col-lg-6">
            {{-- Success Message --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="mt-4">
                <div class="mb-4">
                    <h4 class="fw-bold text-primary"><i class="fa-solid fa-pen"></i> Data Pengajar</h4>
                </div>

                <div class="bg-white rounded-2 mb-3 p-4">
                    <input type="hidden" name="id" value="{{ $user['id'] }}">

                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                               placeholder="Aditya Kesuma, S.H, M.Kom" 
                               value="{{ old('nama', $user['name']) }}" required>
                        @error('nama')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="email@gmail.com" 
                               value="{{ old('email', $user['email']) }}" required>
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NO TELEPON --}}
                    <div class="mb-3">
                        <label for="noTelp" class="form-label">
                            Nomor Telepon <span class="text-secondary small">(Optional)</span>:
                        </label>
                        <input type="text" class="form-control" id="noTelp" name="no_Telp"
                               placeholder="0851xxxxxxxx" 
                               value="{{ old('no_Telp', $contact['no_telp'] ?? '') }}">
                        @error('noTelp')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NUPTK --}}
                    <div class="mb-3">
                        <label for="nuptk" class="form-label">
                            NUPTK <span class="text-secondary small">(Optional)</span>:
                        </label>
                        <input type="text" class="form-control" id="nuptk" name="nuptk"
                               value="{{ old('nuptk', $contact['nuptk'] ?? '') }}">
                        @error('nuptk')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NIK --}}
                    <div class="mb-3">
                        <label for="nik" class="form-label">
                            NIK <span class="text-secondary small">(Optional)</span>:
                        </label>
                        <input type="text" class="form-control" id="nik" name="nik"
                               value="{{ old('nik', $contact['nik'] ?? '') }}">
                        @error('nik')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SECTION GANTI PASSWORD --}}
                    <div class="bg-body-tertiary rounded-4 p-4">
                        <div class="my-4">
                            <h4><i class="fa-solid fa-lock"></i> Ganti Password</h4>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="password" class="form-label">
                                    Password Baru <span class="text-secondary small">(Min: 8)</span>:
                                </label>
                                <input class="form-control" id="password" name="password" 
                                       type="password" placeholder="****">
                                @error('password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label for="confirm-password" class="form-label">
                                    Confirm Password Baru:
                                </label>
                                <input class="form-control" id="confirm-password" name="password_confirmation" 
                                       type="password" placeholder="****">
                            </div>
                        </div>
                        <p class="small">Isi jika ingin mengganti password untuk pengajar.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- GAMBAR TEACHER --}}
        <div class="col-6 text-center d-none d-lg-block">
            <img src="{{ url('/asset/img/teacher.png') }}" class="img-fluid w-100" alt="Teacher">
        </div>

        {{-- SECTION PILIH KELAS & MAPEL --}}
        <div class="col-12 mt-4 bg-white rounded-2">
            <div class="p-4">
                <div class="row">
                    <div class="col-lg-3 col-12">
                        <h4 class="fw-bold text-primary">
                            <i class="fa-solid fa-book-bookmark"></i> Mengajar
                        </h4>
                    </div>
                    <div class="col-lg-9 col-12 small">
                        Kelas serta mapel dapat dikosongi dan dapat ditambahkan dikemudian waktu.
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-6 col-lg-5">
                        <label for="kelas" class="form-label">Kelas:</label>
                        <select class="form-select" id="kelas">
                            <option value="kosong" selected>Pilih Kelas</option>
                            @foreach ($kelas as $kelasItem)
                                <option value="{{ $kelasItem->id }}">{{ $kelasItem->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-6 col-lg-5">
                        <label for="mapel" class="form-label">Mapel:</label>
                        <select class="form-select" id="mapel" disabled>
                            <option value="" selected>Pilih Kelas terlebih dahulu</option>
                        </select>
                        <div id="loading" style="display: none;">Loading...</div>
                    </div>
                    
                    <div class="col-12 col-lg-2">
                        <label class="form-label">&nbsp;</label>
                        <button class="d-block mt-2 btn btn-primary w-100" id="btnTambah" type="button" disabled>
                            Tambah +
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL KELAS & MAPEL --}}
        <div class="col-12 mt-4 bg-white rounded-2">
            <div class="p-4">
                <table id="tabelKelas" class="table">
                    <thead>
                        <tr>
                            <th>Nama Kelas</th>
                            <th>Nama Mapel</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan ditambah dari JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TOMBOL SIMPAN --}}
    <div class="p-4">
        <button type="submit" class="btn-lg btn btn-primary w-100">Simpan dan Lanjutkan</button>
    </div>
</form>

<script>
    // ==========================================
    // KONFIGURASI DARI SERVER KE JAVASCRIPT
    // ==========================================
    window.teacherConfig = {
        urls: {
            searchKelasMapel: "{{ route('searchKelasMapel') }}",
            cekKelasMapel: "{{ route('cekKelasMapel') }}",
            tambahEditorAccess: "{{ route('tambahEditorAccess') }}",
            deleteEditorAccess: "{{ route('deleteEditorAccess') }}"
        },
        userId: "{{ $user->id }}",
        csrfToken: "{{ csrf_token() }}",
        existingData: [
            @if(isset($mapelEnrolled) && count($mapelEnrolled) > 0)
                @foreach ($mapelEnrolled as $enrolled)
                    {
                        kelasId: '{{ $enrolled->kelas_id }}',
                        mapelId: '{{ $enrolled->mapel_id }}',
                        kelasName: '{{ DB::select("SELECT name FROM kelas WHERE id = " . $enrolled->kelas_id)[0]->name ?? "Unknown" }}',
                        mapelName: '{{ DB::select("SELECT name FROM mapels WHERE id = " . $enrolled->mapel_id)[0]->name ?? "Unknown" }}'
                    }{{ !$loop->last ? ',' : '' }}
                @endforeach
            @endif
        ]
    };
</script>
<script src="{{ asset('asset/js/customJS/mengelolakelasdanmapel.js') }}"></script>

@endsection