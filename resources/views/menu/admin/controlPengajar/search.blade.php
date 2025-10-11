@extends('layout.template.mainTemplate')

@section('container')

    <!-- Breadcrumb -->
    <div class="col-12 ps-4 pe-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('viewPengajar') }}">Data Pengajar</a></li>
                <li class="breadcrumb-item active">Hasil Pencarian</li>
            </ol>
        </nav>
    </div>

    <!-- Header -->
    <div class="ps-4 pe-4">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <h4 class="fw-bold mb-0">{{ $title }}</h4>
            <a href="{{ route('viewPengajar') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row px-4 pb-4">
        <div class="col-12 bg-white rounded-2 p-3 shadow-sm">
            @if ($pengajar->count() > 0)
                <!-- Info hasil pencarian -->
                <div class="mb-3">
                    <h6 class="fw-bold mb-1">
                        Pencarian untuk: <span class="text-primary">"{{ $keyword }}"</span>
                    </h6>
                    <p class="text-muted small mb-0">Ditemukan {{ $pengajar->total() }} hasil.</p>
                </div>

                <!-- Table hasil -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle">
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
                                    <td>{{ $loop->iteration + ($pengajar->currentPage()-1) * $pengajar->perPage() }}</td>
                                    <td>
                                        <img src="{{ $p->gambar ? asset('storage/file/img-upload/' . $p->gambar) : '/asset/icons/profile-men.svg' }}" 
                                             class="rounded-circle" width="40" alt="Foto">
                                    </td>
                                    <td class="fw-bold">{{ $p->name }}</td>
                                    <td>{{ $p->Contact->nuptk ?? '-' }}</td>
                                    <td>{{ $p->Contact->nik ?? '-' }}</td>
                                    <td>
                                        @if ($p->EditorAccess && count($p->EditorAccess) > 0)
                                            <span class="badge bg-primary">{{ count($p->EditorAccess) }} Kelas</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Ada</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($p->email, 20) }}</td>
                                    <td>{{ $p->Contact->no_telp ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('viewProfileAdmin', ['token' => encrypt($p->id)]) }}" 
                                               class="btn btn-info" title="Lihat">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('viewUpdatePengajar', ['token' => encrypt($p->id)]) }}" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('destroyPengajar') }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus pengajar ini?')">
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

                    <div class="d-flex justify-content-center mt-2">
                        {{ $pengajar->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <!-- Empty Result -->
                <div class="text-center py-4">
                    <img src="{{ url('/asset/img/not-found.png') }}" alt="No result" 
                         class="img-fluid mb-2" style="max-width: 200px;">
                    <h6 class="text-muted">Tidak Ada Hasil</h6>
                    <p class="text-muted small">
                        Pengajar dengan kata kunci <b>{{ $keyword }}</b> tidak ditemukan.
                    </p>
                    <a href="{{ route('viewPengajar') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Data Pengajar
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
