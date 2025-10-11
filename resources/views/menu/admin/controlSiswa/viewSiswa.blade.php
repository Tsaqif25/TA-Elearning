@extends('layout.template.mainTemplate')

@section('container')
<div class="content w-100">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <!-- Header -->
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Manajemen Data Siswa</h5>
                    <p class="text-muted small mb-0">Kelola data siswa berdasarkan kelas, NIS, dan status akun</p>
                </div>
                <div class="mt-3 mt-lg-0 d-flex gap-2">
                    <a href="{{ route('exportSiswa') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-file-export me-1"></i> Export
                    </a>
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-solid fa-file-import me-1"></i> Import
                    </button>
                    <a href="{{ route('viewTambahSiswa') }}" class="btn btn-grad btn-sm">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Siswa
                    </a>
               
                </div>
            </div>

            <!-- Search Form -->
    <form action="{{ route('searchSiswa') }}" method="GET" class="row g-2 mb-3">
    <!-- Keyword -->
    <div class="col-md-6">
        <input type="text" name="keyword" class="form-control"
               placeholder="Cari siswa berdasarkan nama atau NIS..."
               value="{{ request('keyword') }}">
    </div>

    <!-- Filter Kelas -->
    <div class="col-md-3">
        <select name="kelas" class="form-select">
    <option value="">Semua Kelas</option>
    <option value="X" {{ request('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
    <option value="XI" {{ request('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
    <option value="XII" {{ request('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
</select>

    </div>

    <!-- Filter Status Akun -->
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Terdaftar</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Belum Terdaftar</option>
        </select>
    </div>
</form>


            <!-- Data Table -->
    <div class="table-responsive">
    <table class="table table-hover align-middle">
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
            @forelse ($siswa as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
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
                            {{-- Lihat Profil (jika punya akun) --}}
                          @if ($s->punya_akun)
  @if ($s->punya_akun)
    <a href="{{ route('viewProfileSiswa', ['siswa_id' => $s->user_id]) }}" 
       class="btn btn-info" title="Lihat Profil">
        <i class="fa-solid fa-eye"></i>
    </a>
@endif

@endif


                            {{-- Edit --}}
                            <a href="{{ route('viewUpdateDataSiswa', ['data_siswa' => $s->id]) }}" 
                               class="btn btn-warning" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            {{-- Hapus langsung dengan confirm --}}
                            <form action="{{ route('destroyDataSiswa') }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                @csrf
                                <input type="hidden" name="idHapus" value="{{ $s->id }}">
                                <button type="submit" class="btn btn-danger" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <img src="{{ url('/asset/img/not-found.png') }}" 
                             alt="No data" class="img-fluid w-25 mb-3">
                        <br>
                        <strong class="text-muted">Belum ada data siswa</strong>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-3">
    {{ $siswa->links('pagination::bootstrap-5') }}
</div>
            {{ $siswa->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>



<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info small">Pastikan file Excel sesuai format template.</div>
                <div class="mb-3">
                    <a href="{{ route('contohSiswa') }}" class="btn btn-warning btn-sm">
                        <i class="fa-solid fa-download"></i> Download Template
                    </a>
                </div>
                <form method="POST" action="{{ route('importSiswa') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Excel</label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-upload"></i> Import
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function changeValue(id) {
        document.getElementById('deleteButton').value = id;
    }
</script>
@endpush
@endsection
