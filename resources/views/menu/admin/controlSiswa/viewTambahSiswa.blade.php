@extends('layout.template.mainTemplate')

@section('container')
    <!-- Breadcrumb -->
    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white shadow-sm px-3 py-2 rounded">
                <li class="breadcrumb-item"><a href="{{ route('viewSiswa') }}">Data Siswa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Siswa</li>
            </ol>
        </nav>
    </div>

    <!-- Header -->
    <div class="ps-4 pe-4 mb-4 d-flex align-items-center">
        <a href="{{ route('viewSiswa') }}" class="btn btn-outline-secondary rounded-circle me-2">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h4 class="fw-bold mb-0">Tambah Data Siswa</h4>
    </div>

    <!-- Main Content -->
    <div class="row px-4 pb-4">
        <!-- Form -->
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-3">
                        <i class="fa-solid fa-pen-to-square me-2"></i> Formulir Tambah Data
                    </h5>

                    <form action="{{ route('validateDataSiswa') }}" method="POST" class="row g-3">
                        @csrf

                        <!-- Nama -->
                        <div class="col-12">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-sm @error('nama') is-invalid @enderror"
                                   id="nama" name="nama" value="{{ old('nama') }}"
                                   placeholder="Masukkan nama lengkap siswa" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kelas -->
                        <div class="col-12">
                            <label for="kelas" class="form-label fw-semibold">Kelas</label>
                            <select class="form-select form-select-sm @error('kelas') is-invalid @enderror"
                                    name="kelas" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($dataKelas as $key)
                                    <option value="{{ $key->id }}" {{ old('kelas') == $key->id ? 'selected' : '' }}>
                                        {{ $key->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- NIS -->
                        <div class="col-12">
                            <label for="nis" class="form-label fw-semibold">NIS (Nomor Induk Siswa)</label>
                            <input type="number" class="form-control form-control-sm @error('nis') is-invalid @enderror"
                                   id="nis" name="nis" value="{{ old('nis') }}"
                                   placeholder="Masukkan NIS" required>
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-grad btn-sm w-100">
                                <i class="fa-solid fa-save me-2"></i> Simpan dan Lanjutkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ilustrasi -->
        <div class="col-lg-5 text-center d-none d-lg-block">
            <img src="{{ url('/asset/img/student-icon.svg') }}" class="img-fluid w-75" alt="Ilustrasi">
        </div>
    </div>
@endsection
