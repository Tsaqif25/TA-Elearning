@extends('layout.template.mainTemplate')

@section('container')
<div class="content w-100">
    <div class="card mb-4">
        <div class="card-body">
            <!-- Header Section -->
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Manajemen Kelas</h5>
                    <p class="text-muted small mb-0">Kelola data kelas</p>
                </div>

                <!-- Action Buttons -->
                <div class="mt-3 mt-lg-0 d-flex gap-2">
                        <a href="{{ route('exportKelas') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-file-export me-1"></i> Export CSV
                        </a>

                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fa-solid fa-file-import me-1"></i> Import
                        </button>

                        <a href="{{ route('viewTambahKelas') }}" class="btn btn-grad btn-sm">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Kelas
                        </a>
                    </div>
            </div> 

            <!-- Filter & Search Form -->
            <form action="{{ route('searchKelas') }}" method="GET" class="row g-2 mb-3">
                <div class="col-md-6">
                    <input type="text" name="keyword" class="form-control"
                           placeholder="Cari nama kelas..."
                           value="{{ request('keyword') }}">
                </div> 
            </form>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jumlah Mapel</th>
                            <th>Jumlah Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kelas as $key)
                            <tr>
                                 <td>{{ $loop->iteration + $kelas->firstItem() - 1 }}</td>
                                <td>{{ $key->name }}</td>
                                <td>{{ count($key->KelasMapel) }}</td>
                                <td>{{ count($key->dataSiswa) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- View -->
                                        <a href="{{ route('viewUpdateKelas',  $key->id) }}"
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <!-- Delete langsung pakai confirm -->
                                        <form action="{{ route('destroyKelas') }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                            @csrf
                                            <input type="hidden" name="idHapus" value="{{ $key->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="{{ url('/asset/img/not-found.png') }}"
                                         alt="Tidak ada data" class="img-fluid w-25 mb-3">
                                    <br>
                                    <strong class="text-muted">Data belum ditambahkan</strong>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $kelas->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info small">Pastikan file Excel sesuai format template.</div>
                <div class="mb-3">
                    <a href="{{ route('contohKelas') }}" class="btn btn-warning btn-sm">
                        <i class="fa-solid fa-download"></i> Download Template
                    </a>
                </div>
                <form method="POST" action="{{ route('importKelas') }}" enctype="multipart/form-data">
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

@endsection
