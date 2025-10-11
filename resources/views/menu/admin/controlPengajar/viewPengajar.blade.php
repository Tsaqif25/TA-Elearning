{{-- pengajar/index.blade.php --}}
@extends('layout.template.mainTemplate')

@section('container')
<div class="content w-100">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <!-- Header -->
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Manajemen Data Pengajar</h5>
                    <p class="text-muted small mb-0">Kelola data pengajar, mata pelajaran, dan kontak</p>
                </div>
                <div class="mt-3 mt-lg-0 d-flex gap-2">
                    <a href="{{ route('exportPengajar') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-file-export me-1"></i> Export
                    </a>
                    <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-solid fa-file-import me-1"></i> Import
                    </button>
                    
                    <a href="{{ route('viewTambahPengajar') }}" class="btn btn-grad btn-sm ">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Pengajar
                    </a>
                </div>
            </div>

            @if ($pengajar->count() > 0)
                <!-- Search Form -->
                <form action="{{ route('searchPengajar') }}" method="GET" class="row g-2 mb-3">
                    <div class="col-md-9">
                        <input type="text" id="search" name="keyword" class="form-control"
                               placeholder="Cari pengajar berdasarkan nama, email, atau NUPTK..."
                               value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa-solid fa-search me-1"></i> Cari
                        </button>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>NUPTK</th>
                                <th>NIK</th>
                                <th>Mengajar</th>
                                <th>Email</th>
                                <th>No Telp</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengajar as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ $p->gambar ? asset('storage/file/img-upload/' . $p->gambar) : '/asset/icons/profile-men.svg' }}"
                                             class="rounded-circle border" width="40" height="40" alt="Foto">
                                    </td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->Contact->nuptk ?? '-' }}</td>
                                    <td>{{ $p->Contact->nik ?? '-' }}</td>
                                    <td>{{ $p->EditorAccess ? count($p->EditorAccess) : 0 }} Kelas</td>
                                    <td>{{ Str::limit($p->email, 20) }}</td>
                                    <td>{{ $p->Contact->no_telp ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                        <a href="{{ route('viewUpdatePengajar', ['user' => $p->id]) }}" 
                                            class="btn btn-warning" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                       
                                            <!-- Hapus langsung dengan confirm -->
                                            <form action="{{ route('destroyPengajar') }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus data pengajar ini?')">
                                                @csrf
                                                <input type="hidden" name="idHapus" value="{{ $p->id }}">
                                                <button type="submit" class="btn btn-danger" title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $pengajar->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <img src="{{ url('/asset/img/not-found.png') }}" alt="No data" class="img-fluid mb-3" style="max-width: 250px;">
                    <h5 class="text-muted">Belum ada data pengajar</h5>
                    <p class="text-muted">Tambahkan data pengajar dengan klik tombol <b>Tambah Pengajar</b> di atas.</p>
                </div>
            @endif
        </div>
    </div>
</div>
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
                    <a href="{{ route('downloadTemplatePengajar') }}" class="btn btn-warning btn-sm">
                        <i class="fa-solid fa-download"></i> Download Template
                    </a>
                </div>
                <form method="POST" action="{{ route('importPengajar') }}" enctype="multipart/form-data">
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
