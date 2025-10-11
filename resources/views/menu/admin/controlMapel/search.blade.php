@extends('layout.template.mainTemplate')

@section('container')

    <!-- Header -->
    <div class="ps-4 pe-4">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <h4 class="fw-bold mb-0">Hasil Pencarian Mapel</h4>
            <a href="{{ route('viewMapel') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row px-4 pb-4">
        <div class="col-12 bg-white rounded-2 p-3 shadow-sm">
            @if ($mapels->count() > 0)
                <!-- Info hasil pencarian -->
                <div class="mb-3">
                    <h6 class="fw-bold mb-1">
                        Pencarian untuk: <span class="text-primary">"{{ $keyword }}"</span>
                    </h6>
                    <p class="text-muted small mb-0">Ditemukan {{ $mapels->total() }} hasil.</p>
                </div>

                <!-- Tabel hasil -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="30%">Nama</th>
                                <th width="55%">Deskripsi</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mapels as $m)
                                <tr>
                                    <td>{{ $loop->iteration + ($mapels->currentPage()-1) * $mapels->perPage() }}</td>
                                    <td class="fw-bold">{{ $m->name }}</td>
                                    <td class="text-muted small">
                                        {{ Str::limit($m->deskripsi ?? 'Tidak ada deskripsi', 60) }}
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('viewUpdateMapel', $m->id) }}" 
                                               class="btn btn-warning">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
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

                    <div class="d-flex justify-content-center mt-2">
                        {{ $mapels->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <!-- Jika tidak ada hasil -->
                <div class="text-center py-4">
                    <img src="{{ url('/asset/img/not-found.png') }}" alt="No result" 
                         class="img-fluid mb-2" style="max-width: 180px;">
                    <h6 class="text-muted">Tidak Ada Hasil</h6>
                    <p class="text-muted small">
                        Mapel dengan kata kunci <b>{{ $keyword }}</b> tidak ditemukan.
                    </p>
                    <a href="{{ route('viewMapel') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Data Mapel
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
