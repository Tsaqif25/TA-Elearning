@extends('layout.template.mainTemplate')

@section('container')
    <!-- Header -->
    <div class="ps-4 pe-4">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('viewKelas') }}" class="btn btn-outline-secondary rounded-circle me-2">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0">Tambah Kelas Baru</h4>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row px-4 pb-4">
        <!-- Form Tambah -->
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-3">
                        <i class="fa-solid fa-plus-circle me-2"></i> Formulir Tambah Kelas
                    </h5>

                    {{-- Alert --}}
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show py-2 px-3">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('validateNamaKelas') }}" method="POST" class="row g-3">
                        @csrf

                        <!-- Nama Kelas -->
                        <div class="col-12">
                            <label for="nama" class="form-label fw-semibold">Nama Kelas</label>
                            <input type="text"
                                   class="form-control form-control-sm @error('name') is-invalid @enderror"
                                   id="nama" name="name"
                                   placeholder="Contoh: XII IPA 1"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pilih Mapel (Checkbox) -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Pilih Mapel</label>
                            <div class="row">
                                @foreach($dataMapel as $m)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="mapels[]"
                                                   value="{{ $m->id }}" id="mapel{{ $m->id }}"
                                                   {{ (is_array(old('mapels')) && in_array($m->id, old('mapels'))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mapel{{ $m->id }}">
                                                {{ $m->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-grad btn-sm w-100">
                                <i class="fa-solid fa-save me-2"></i> Simpan Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ilustrasi -->
        <div class="col-lg-5 text-center d-none d-lg-block">
            <img src="{{ url('/asset/img/office.png') }}" class="img-fluid w-75" alt="Ilustrasi">
        </div>
    </div>
@endsection

    {{-- <script>
        // ===== FUNGSI TAMBAH MAPEL =====
        function tambahMapel() {
            const mapelSelect = document.getElementById("mapel");
            const selectedMapel = mapelSelect.value;
            const selectedMapelText = mapelSelect.options[mapelSelect.selectedIndex].text;
            const tabelBody = document.querySelector("#tabelMapel tbody");

            // Validasi input kosong
            if (!selectedMapel || selectedMapel === "") {
                alert("Pilih mapel terlebih dahulu!");
                return;
            }

            // Cek duplikat - cari semua input hidden yang sudah ada
            const existingMapels = document.querySelectorAll("input[name='mapels[]']");
            for (let i = 0; i < existingMapels.length; i++) {
                if (existingMapels[i].value === selectedMapel) {
                    alert("Mapel sudah ada dalam tabel!");
                    mapelSelect.value = "";
                    return;
                }
            }

            // Buat baris baru
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>
                    ${selectedMapelText}
                    <input type="hidden" name="mapels[]" value="${selectedMapel}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusMapel(this)">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            `;

            // Tambah ke tabel
            tabelBody.appendChild(newRow);

            // Reset dropdown
            mapelSelect.value = "";

            console.log("Mapel berhasil ditambahkan: " + selectedMapelText);
        }

        // ===== FUNGSI HAPUS MAPEL =====
        function hapusMapel(button) {
            if (confirm("Yakin hapus mapel ini?")) {
                const row = button.closest("tr");
                const mapelName = row.querySelector("td").textContent.trim();
                row.remove();
                console.log("Mapel berhasil dihapus: " + mapelName);
            }
        }

        // ===== TEST FUNCTIONS =====
        document.addEventListener("DOMContentLoaded", function() {
            console.log("Create Kelas Page Loaded!");
            console.log("Total mapels: " + document.querySelectorAll("input[name='mapels[]']").length);
        });

        // Show success modal if needed
        @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        });
        @endif
    </script> --}}
{{-- @endsection --}}