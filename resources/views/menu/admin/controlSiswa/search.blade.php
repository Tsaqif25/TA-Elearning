@extends('layout.template.mainTemplate')

@section('container')

    <!-- Header -->
    <div class="ps-4 pe-4">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <h4 class="fw-bold mb-0">{{ $title }}</h4>
            <a href="{{ route('viewSiswa') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row px-4 pb-4">
        <div class="col-12 bg-white rounded-2 p-3 shadow-sm">
            @if ($siswa->count() > 0)
                <!-- Info hasil pencarian -->
                <div class="mb-3">
                    <h6 class="fw-bold mb-1">
                        Pencarian untuk: <span class="text-primary">"{{ $keyword }}"</span>
                    </h6>
                    <p class="text-muted small mb-0">Ditemukan {{ $siswa->total() }} hasil.</p>
                </div>

                <!-- Tabel hasil -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>NIS</th>
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $s)
                                <tr>
                                    <td>{{ $loop->iteration + ($siswa->currentPage()-1) * $siswa->perPage() }}</td>
                                    <td>{{ $s->name }}</td>
                                    <td>{{ $s->kelas->name ?? '-' }}</td>
                                    <td>{{ $s->nis }}</td>
                                    <td>
                                        <span class="badge {{ $s->punya_akun ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $s->punya_akun ? 'Terdaftar' : 'Belum Terdaftar' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if ($s->punya_akun)
                                                <a href="{{ route('viewProfileSiswa', ['token' => encrypt($s->user_id)]) }}" 
                                                   class="btn btn-info">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('viewUpdateDataSiswa', ['data_siswa' => $s->id]) }}" 
                                               class="btn btn-warning">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('destroyDataSiswa') }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                <input type="hidden" name="idHapus" value="{{ $s->id }}">
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
                        {{ $siswa->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <!-- Jika tidak ada hasil -->
                <div class="text-center py-4">
                    <img src="{{ url('/asset/img/not-found.png') }}" alt="No result" 
                         class="img-fluid mb-2" style="max-width: 180px;">
                    <h6 class="text-muted">Tidak Ada Hasil</h6>
                    <p class="text-muted small">Siswa dengan kata kunci <b>{{ $keyword }}</b> tidak ditemukan.</p>
                    <a href="{{ route('viewSiswa') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Data Siswa
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
