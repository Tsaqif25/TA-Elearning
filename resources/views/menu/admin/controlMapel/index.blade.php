@extends('layout.template.mainTemplate')

@section('container')
    <div class="content w-100">
        <div class="card mb-4 shadow-sm">
            <div class="card-body">

                <!-- Header -->
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Manajemen Data Mapel</h5>
                        <p class="text-muted small mb-0">Kelola daftar mata pelajaran dan deskripsinya</p>
                    </div>
                    <div class="mt-3 mt-lg-0 d-flex gap-2">
                        <a href="{{ route('exportMapel') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa-solid fa-file-export me-1"></i> Export
                        </a>
                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="fa-solid fa-file-import me-1"></i> Import
                        </button>
                        <a href="{{ route('viewTambahMapel') }}" class="btn btn-grad btn-sm">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Mapel
                        </a>
                    </div>
                </div>
                <!-- Import Modal -->
                <div class="modal fade" id="importModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Import Data Mapel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-info small">Pastikan file Excel sesuai format template.</div>
                                <div class="mb-3">
                                    <a href="{{ route('contohMapel') }}" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-download"></i> Download Template
                                    </a>
                                </div>
                                <form method="POST" action="{{ route('importMapel') }}" enctype="multipart/form-data">
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


                <!-- Alert Messages -->
                @foreach (['delete-success', 'import-success', 'import-error'] as $msg)
                    @if (session($msg))
                        <div
                            class="alert alert-{{ $msg == 'import-error' ? 'danger' : 'success' }} alert-dismissible fade show py-2 px-3">
                            {{ session($msg) }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                @endforeach

                @if ($mapel->count() > 0)
                    <!-- Search Bar -->
                    <form action="{{ route('searchMapel') }}" method="GET" class="mb-3">
                        <div class="input-group input-group-sm">
                            <input type="text" name="keyword" class="form-control"
                                placeholder="Cari mapel (nama atau deskripsi)..." value="{{ request('keyword') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fa-solid fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mapel as $m)
                                    <tr>
                                        <td>{{ $loop->iteration + $mapel->firstItem() - 1 }}</td>
                                        <td>{{ $m->name }}</td>
                                        <td>{{ Str::limit($m->deskripsi ?? 'Tidak ada deskripsi', 50) }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <!-- Edit -->
                                                <a href="{{ route('viewUpdateMapel', $m->id) }}" class="btn btn-warning">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <!-- Delete -->
                                                <form action="{{ route('destroyMapel') }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus mapel ini?')">
                                                    @csrf
                                                    <input type="hidden" name="idHapus" value="{{ $m->id }}">
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

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-2">
                            {{ $mapel->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="text-center py-4">
                        <img src="{{ url('/asset/img/not-found.png') }}" class="img-fluid mb-2" style="max-width: 180px;">
                        <h6 class="text-muted">Belum Ada Data Mapel</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection