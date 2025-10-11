@extends('layout.template.mainTemplate')

@section('container')

    <!-- Header -->
    <div class="ps-4 pe-4 mb-3 d-flex justify-content-between align-items-center border-bottom pb-2">
        <h4 class="fw-bold mb-0">{{ $title }}</h4>
        <a href="{{ route('viewKelas') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row px-4 pb-4">
        <div class="col-12 bg-white rounded-2 shadow-sm p-3">
            @if ($kelas->count() > 0)
                <!-- Result Info -->
                <div class="mb-3">
                    <h6 class="fw-bold mb-1">
                        Pencarian untuk: <span class="text-primary">"{{ $keyword }}"</span>
                    </h6>
                    <p class="text-muted small mb-0">Ditemukan {{ $kelas->total() }} hasil.</p>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Jumlah Mapel</th>
                                <th>Jumlah Siswa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas as $key)
                                <tr>
                                    <td>{{ $loop->iteration + ($kelas->currentPage()-1) * $kelas->perPage() }}</td>
                                    <td>{{ $key->name }}</td>
                                    <td>{{ $key->KelasMapel ? $key->KelasMapel->count() : 0 }}</td>
                                    <td>{{ count($key->dataSiswa) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- View -->
                                            <button type="button" class="btn btn-info"
                                                    onclick="getData({{ $key->id }})">
                                                <i class="fa-regular fa-eye"></i>
                                            </button>
                                            <!-- Edit -->
                                            <a href="{{ route('viewUpdateKelas', ['kelas' => $key->id]) }}"
                                               class="btn btn-secondary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <!-- Delete -->
                                            <form action="{{ route('destroyKelas') }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                                @csrf
                                                <input type="hidden" name="idHapus" value="{{ $key->id }}">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-2">
                        {{ $kelas->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <!-- Empty Result -->
                <div class="text-center py-4">
                    <img src="{{ url('/asset/img/not-found.png') }}" 
                         alt="No result" class="img-fluid mb-2" style="max-width: 180px;">
                    <h6 class="text-muted">Tidak Ada Hasil</h6>
                    <p class="text-muted small">Kelas dengan kata kunci <b>{{ $keyword }}</b> tidak ditemukan.</p>
                    <a href="{{ route('viewKelas') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Data Kelas
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
