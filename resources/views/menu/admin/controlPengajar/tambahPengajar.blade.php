@extends('layout.template.mainTemplate')

@section('container')
<!-- Header -->
<div class="ps-4 pe-4 mb-4 d-flex align-items-center">
    <a href="{{ route('viewPengajar') }}" class="btn btn-outline-secondary rounded-circle me-3">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h2 class="fw-bold mb-0">Tambah Pengajar</h2>
</div>

<form action="{{ route('storePengajar') }}" method="POST">
    @csrf

    <div class="row p-4">
        <!-- Kolom Kiri -->
        <div class="col-lg-7">
            <!-- Data Pengajar -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-3">
                        <i class="fa-solid fa-user me-2"></i> Data Pengajar
                    </h5>
                    <div class="row">
                        {{-- Nama --}}
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" class="form-control"
                                   value="{{ old('nama') }}" placeholder="Nama lengkap" required>
                            @error('nama')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                   value="{{ old('email') }}" placeholder="email@gmail.com" required>
                            @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        {{-- Telepon --}}
                        <div class="col-md-6 mb-3">
                            <label for="noTelp" class="form-label">Nomor Telepon <span class="text-secondary small">(Opsional)</span></label>
                            <input type="tel" id="noTelp" name="noTelp" class="form-control"
                                   value="{{ old('noTelp') }}" placeholder="0851xxxxxxx">
                            @error('noTelp')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        {{-- NUPTK --}}
                        <div class="col-md-6 mb-3">
                            <label for="nuptk" class="form-label">NUPTK <span class="text-secondary small">(Opsional)</span></label>
                            <input type="text" id="nuptk" name="nuptk" class="form-control"
                                   value="{{ old('nuptk') }}" placeholder="NUPTK">
                            @error('nuptk')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        {{-- NIK --}}
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">NIK <span class="text-secondary small">(Opsional)</span></label>
                            <input type="text" id="nik" name="nik" class="form-control"
                                   value="{{ old('nik') }}" placeholder="NIK">
                            @error('nik')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        {{-- Password --}}
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Minimal 8 karakter" required>
                            @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="col-md-6 mb-3">
                            <label for="confirm-password" class="form-label">Konfirmasi Password</label>
                            <input type="password" id="confirm-password" name="confirm-password" class="form-control"
                                   placeholder="Ulangi password" required>
                            @error('confirm-password')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Kelas & Mapel -->
            {{-- <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-book-bookmark me-2"></i> Kelas & Mapel</h5>
                    <p class="small text-muted">Boleh dikosongi, bisa ditambahkan nanti.</p>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select id="kelas" class="form-select">
                                <option value="" selected>Pilih Kelas</option>
                                @foreach ($dataKelas as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="mapel" class="form-label">Mapel</label>
                            <select id="mapel" class="form-select" >
                                <option value="">Pilih kelas terlebih dahulu</option>
                            </select>
                            <div id="loading" class="small text-muted mt-1" style="display:none;">Loading...</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button id="btnTambah" type="button" class="btn btn-primary w-100" >
                                <i class="fa-solid fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tabelKelas" class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kelas</th>
                                    <th>Mapel</th>
                                    <th class="text-center" style="width:100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <input type="hidden" id="kelasMapelInput" name="kelas_mapel">
                </div>
            </div> --}}
        </div>
           <div class="col-12 mt-4 bg-white rounded-2">
            <div class="mt-4">
                <div class="p-4">
                    <div class="row">
                        <div class="col-3">
                            <h3 class="fw-bold text-primary"><i class="fa-solid fa-book-bookmark"></i> Kelas & Mapel</h3>
                        </div>
                        <div class="col-9 small">
                            Kelas serta mapel dapat dikosongi dan dapat ditambahkan di kemudian waktu.
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 col-lg-5">
                                    <label for="kelas">Kelas :</label>
                                    <select class="form-select" id="kelas" aria-label="Default select example">
                                        <option value="kosong" selected>Pilih Kelas</option>
                                        @foreach ($dataKelas as $key)
                                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 col-lg-5">
                                    <label for="mapel" class="form-label">Mapel :</label>
                                    <select class="form-select" id="mapel" aria-label="Default select example"
                                        disabled>
                                        <option value="" selected>Pilih Kelas terlebih dahulu</option>
                                    </select>
                                    <div id="loading" style="display: none;">Loading...</div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <label for="" class="form-label"></label>
                                    <button disabled class="d-block mt-2 btn btn-primary w-100" id="btnTambah"
                                        type="button">Tambah +</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input tersembunyi untuk menerima data dari tabel -->
        <input type="hidden" name="data[kelas][]" id="kelasInput">

        <div class="col-12 mt-4 bg-white rounded-2">
            <div class="mt-4">
                <div class="p-4">
                    <div class="">
                        <table id="tabelKelas" class="table">
                            <thead>
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th>Nama Mapel</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data mapel akan ditambahkan oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-lg-5 d-none d-lg-block text-center">
            <img src="{{ url('/asset/img/teacher.png') }}" class="img-fluid w-75" alt="Teacher">
        </div>
    </div>

    <!-- Submit -->
    <div class="px-4 mb-5">
        <button type="submit" class="btn btn-primary btn-lg w-100">
            <i class="fa-solid fa-save me-2"></i> Simpan Data Pengajar
        </button>
    </div>
</form>

<!-- Scripts -->
   <script>
        var url = "{{ route('searchKelasMapel') }}";
        var urlCek = "{{ route('cekKelasMapel') }}";
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('#kelas').on('change', function() {
                if ($('#kelas').val() != 'kosong') {
                    $('#mapel').prop('disabled', true);
                    $('#loading').show();

                    const selectedKelasId = $('#kelas').val();

                    // Mengganti URL_API dengan URL sesuai dengan API Anda
                    var apiUrl = url;

                    $.ajax({
                        url: apiUrl,
                        method: 'GET',
                        data: {
                            kelasId: selectedKelasId
                        },
                        success: function(dataMapel) {
                            console.log(dataMapel);
                            $('#mapel').empty().append(
                                '<option value="" selected>Pilih Mapel</option>');

                            $.each(dataMapel, function(index, mapel) {
                                if (mapel.exist) {
                                    $('#mapel').append('<option disabled value="' +
                                        mapel.id + '">' +
                                        mapel.name + '</option>');
                                } else {
                                    $('#mapel').append('<option value="' + mapel.id +
                                        '">' +
                                        mapel.name + '</option>');
                                }
                            });

                            $('#mapel').prop('disabled', false);
                            $('#loading').hide();
                            $('#btnTambah').prop('disabled', false);
                        },
                        error: function(xhr, status, error) {
                            console.error('Terjadi kesalahan:', error);
                            $('#mapel').prop('disabled', true);
                            $('#loading').hide();
                            $('#btnTambah').prop('disabled', true);
                        }

                    });
                } else {
                    $('#mapel').prop('disabled', true).append(
                        '<option value="" selected>Pilih Kelas terlebih dahulu</option>');
                    $('#btnTambah').prop('disabled', true);
                }

            });
        });
    </script>

    <script>
        var rowIndex = 0;
        var rowData = [];

        // Function to add a row to the table
        function addRowToTable() {
            var kelas = $('#kelas').val();
            var mapel = $('#mapel').val();

            var kelasHtml = $('#kelas option:selected').html();
            var mapelHtml = $('#mapel option:selected').html();

            var exists = rowData.some(function(row) {
                return row.kelas === kelas && row.mapel === mapel;
            });

            if (kelas !== 'kosong' && mapel !== '' && !exists) {
                rowIndex++;
                // Create a new row and append it to the table
                var newRow = '<tr>' +
                    '<td>' + kelasHtml + '</td>' +
                    '<td>' + mapelHtml + '</td>' +
                    '<td><button type="button" class="btn btn-danger delete-btn">Delete</button></td>' +
                    '</tr>';
                $('#tabelKelas tbody').append(newRow);

                rowData.push({
                    kelas: kelas,
                    mapel: mapel
                });

                // Clear the select fields
                $('#kelas').val('kosong');
                $('#mapel').empty().append('<option value="" selected>Pilih Mapel</option>');
                $('#mapel').prop('disabled', true);
                $('#btnTambah').prop('disabled', true);
            } else if (exists) {
                // Tampilkan pesan atau lakukan tindakan lain jika pasangan sudah ada
                alert('Kelas dan Mapel sudah ada dalam daftar');
            } else if (mapel == '') {
                alert('Pilih kelas/mapel terlebih dahulu');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add a click event listener to the "Tambah" button
            $('#btnTambah').on('click', function() {
                addRowToTable();
            });

            // Add a click event listener to delete buttons
            $('#tabelKelas').on('click', '.delete-btn', function() {
                var row = $(this).closest('tr');
                var rowIndex = row.index(); // Get the row index of the clicked row
                row.remove(); // Remove the row from the table

                // Remove the corresponding row data from the rowData array
                rowData.splice(rowIndex, 1);
            });

            // Add a submit event listener to the form
            $('form').on('submit', function() {
                // Set the hidden input values with the rowData JSON
                $('#kelasInput').val(JSON.stringify(rowData));
            });
        });
    </script>
@endsection