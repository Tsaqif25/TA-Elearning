{{-- FILE: resources/views/menu/admin/controlMapel/create.blade.php --}}
@extends('layout.template.mainTemplate')

@section('container')
    <!-- Header -->
    <div class="ps-4 pe-4">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('viewMapel') }}" class="btn btn-outline-secondary rounded-circle me-2">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0">Tambah Mapel Baru</h4>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row px-4 pb-4">
        <!-- Form -->
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-3">
                        <i class="fa-solid fa-plus-circle me-2"></i> Form Tambah Mapel
                    </h5>

                    <form action="{{ route('validateNamaMapel') }}" method="POST" class="row g-3">
                        @csrf
                        <!-- Nama -->
                        <div class="col-12">
                            <label for="name" class="form-label fw-semibold">Nama Mata Pelajaran</label>
                            <input type="text"
                                   class="form-control form-control-sm @error('name') is-invalid @enderror"
                                   id="name" name="name"
                                   placeholder="Contoh: Matematika, Bahasa Indonesia..."
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi (Opsional)</label>
                            <textarea class="form-control form-control-sm"
                                      id="deskripsi" name="deskripsi"
                                      rows="3" maxlength="500"
                                      placeholder="Berikan deskripsi singkat...">{{ old('deskripsi') }}</textarea>
                           
                        </div>

                        <!-- Action -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-grad btn-sm w-100">
                                <i class="fa-solid fa-save me-2"></i> Simpan Mapel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ilustrasi -->
        <div class="col-lg-5 text-center d-none d-lg-block">
            <img src="{{ url('/asset/img/exam.png') }}" class="img-fluid w-75" alt="Ilustrasi Mapel">
        </div>
    </div>


@endsection
