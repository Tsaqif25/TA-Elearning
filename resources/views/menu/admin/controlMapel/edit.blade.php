{{-- FILE: resources/views/menu/admin/controlMapel/edit.blade.php --}}
@extends('layout.template.mainTemplate')

@section('container')
    <!-- Header -->
    <div class="ps-4 pe-4">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('viewMapel') }}" class="btn btn-outline-secondary rounded-circle me-2">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0">Edit Mapel: {{ $mapel->name }}</h4>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row px-4 pb-4">
        <!-- Form Edit -->
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-3">
                        <i class="fa-solid fa-pen-to-square me-2"></i> Formulir Edit Mapel
                    </h5>
                    <form action="{{ route('updateMapel') }}" method="POST" class="row g-3">
                        @csrf
                        <input type="hidden" name="id" value="{{ $mapel->id }}">
                        <!-- Nama -->
                        <div class="col-12">
                            <label for="nama" class="form-label fw-semibold">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control form-control-sm @error('nama') is-invalid @enderror"
                                id="nama" name="nama" placeholder="Contoh: Matematika, Bahasa Indonesia..."
                                value="{{ old('nama', $mapel->name) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi (Opsional)</label>
                            <textarea class="form-control form-control-sm" id="deskripsi" name="deskripsi" rows="3" maxlength="500"
                                placeholder="Berikan deskripsi singkat...">{{ old('deskripsi', $mapel->deskripsi) }}</textarea>
                        </div>
                        <!-- Action Buttons -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-grad btn-sm w-100">
                                <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ilustrasi -->
        <div class="col-lg-5 text-center d-none d-lg-block">
            <img src="{{ url('/asset/img/exam.png') }}" class="img-fluid w-75" alt="Mapel">
        </div>
    </div>


@endsection
