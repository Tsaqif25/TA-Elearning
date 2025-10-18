{{-- @extends('layout.template.mainTemplate') --}}

{{-- @extends('layout.template.mainTemplate') --}}

{{-- @section('container')
<div class="row p-4">
    <div class="col-12 col-lg-12">
        <h2 class="fw-bold mb-3">Daftar Ujian</h2>

        <div class="mb-3">
            <a href="{{ route('ujian.add', ['kelas' => $kelasId, 'mapel' => $mapelId]) }}" class="btn btn-primary">
                ➕ Tambah Ujian
            </a>
        </div>

        <div class="table-responsive bg-white rounded shadow-sm p-3">
            @if ($ujians->count() > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Ujian</th>
                            <th>Durasi</th>
                            <th>Jumlah Soal</th>
                            <th>Deadline</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ujians as $ujian)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ujian->name }}</td>
                                <td>{{ $ujian->time }} menit</td>
                                <td>{{ $ujian->soalUjianMultiple->count() }}</td>
                                <td>{{ \Carbon\Carbon::parse($ujian->due)->format('d M Y H:i') }}</td>
                                <td>
                                    {{-- Kelola Soal --}}
                                    {{-- <a href="{{ route('soal.manage', $ujian->id) }}" class="btn btn-sm btn-info">
                                        📑 Kelola Soal
                                    </a> --}}

                                    {{-- Edit Ujian --}}
                                    {{-- <a href="{{ route('viewUpdateUjian', $ujian->id) }}" class="btn btn-sm btn-warning">
                                        ✏️ Edit
                                    </a> --}}

                                    {{-- Hapus Ujian --}}
                                    {{-- <form action="{{ route('destroyUjian') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="id" value="{{ $ujian->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus ujian ini?')">
                                            🗑️ Hapus
                                        </button>
                                    </form> --}}
                                {{-- </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-5">
                    <img src="{{ url('/asset/img/not-found.png') }}" class="img-fluid w-25 mb-3" style="filter: grayscale(1);">
                    <h5>Belum ada Ujian</h5>
                </div>
            @endif
        </div>
    </div>
</div> --}}



{{-- @endsection --}} 

