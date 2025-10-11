@extends('layout.template.mainTemplate')

@section('container')
    {{-- Header --}}
    <div class="mb-4">
        <h1 class="fw-bold text-dark">Dashboard</h1>
        <span class="text-muted">Pemantauan Data Sistem</span>
    </div>

    {{-- Informasi Sistem --}}
    <div class="bg-body-secondary rounded-4 shadow-sm p-4 mb-5">
        <h3 class="text-primary fw-bold text-center mb-4">Informasi Sistem</h3>

        <div class="row g-4">
            {{-- Chart Materi --}}
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-semibold text-primary">
                        Jumlah Materi (7 Hari Terakhir)
                    </div>
                    <div class="card-body">
                        <canvas id="materiChart" class="w-100" style="height:300px;"></canvas>
                    </div>
                </div>
            </div>

            {{-- Chart Tugas --}}
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-semibold text-primary">
                        Jumlah Tugas (7 Hari Terakhir)
                    </div>
                    <div class="card-body">
                        <canvas id="tugasChart" class="w-100" style="height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Utama --}}
    <div class="row g-4">
        {{-- Baris Pertama --}}
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 text-center p-4">
                <img src="{{ url('/asset/img/student-icon.svg') }}" class="img-fluid mb-3" style="max-width: 80px;" alt="">
                <h5 class="fw-bold text-primary">Total Siswa</h5>
                <span class="text-muted small">Semua data siswa</span>
                <h2 class="fw-bold text-primary mt-2">{{ $data['totalSiswa'] }}</h2>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 text-center p-4">
                <img src="{{ url('/asset/img/kelas-icon.svg') }}" class="img-fluid mb-3" style="max-width: 80px;" alt="">
                <h5 class="fw-bold text-primary">Total Pengajar</h5>
                <span class="text-muted small">User pengajar</span>
                <h2 class="fw-bold text-primary mt-2">{{ $data['totalPengajar'] }}</h2>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 text-center p-4">
                <img src="{{ url('/asset/img/mapel-icon.svg') }}" class="img-fluid mb-3" style="max-width: 80px;" alt="">
                <h5 class="fw-bold text-primary">Total Kelas</h5>
                <span class="text-muted small">Semua kelas</span>
                <h2 class="fw-bold text-primary mt-2">{{ $data['totalKelas'] }}</h2>
            </div>
        </div>

        {{-- Baris Kedua --}}
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 text-center p-4">
                <img src="{{ url('/asset/img/mapel.svg') }}" class="img-fluid mb-3" style="max-width: 80px;" alt="">
                <h5 class="fw-bold text-primary">Total Mapel</h5>
                <span class="text-muted small">Mapel terdaftar</span>
                <h2 class="fw-bold text-primary mt-2">{{ $data['totalMapel'] }}</h2>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 text-center p-4">
                <img src="{{ url('/asset/img/materi.svg') }}" class="img-fluid mb-3" style="max-width: 80px;" alt="">
                <h5 class="fw-bold text-primary">Total Materi</h5>
                <span class="text-muted small">Materi terdaftar</span>
                <h2 class="fw-bold text-primary mt-2">{{ $data['totalMateri'] }}</h2>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 text-center p-4">
                <img src="{{ url('/asset/img/tugas.svg') }}" class="img-fluid mb-3" style="max-width: 80px;" alt="">
                <h5 class="fw-bold text-primary">Total Tugas</h5>
                <span class="text-muted small">Tugas terdaftar</span>
                <h2 class="fw-bold text-primary mt-2">{{ $data['totalTugas'] }}</h2>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        function renderChart(ctxId, label, dataSet) {
            const ctx = document.getElementById(ctxId).getContext('2d');
            const labels = [];
            const counts = [];

            for (let i = 6; i >= 0; i--) {
                const date = moment().subtract(i, 'days').format('MMM-DD');
                labels.push(date);
                const count = dataSet.filter(item => moment(item.created_at).format('MMM-DD') === date).length;
                counts.push(count);
            }

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: counts,
                        borderColor: 'rgba(0,123,255,1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // biar stabil
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        // Data dari backend
        const materiData = @json(App\Models\Materi::where('created_at','>=', now()->subWeek())->get());
        const tugasData = @json(App\Models\Tugas::where('created_at','>=', now()->subWeek())->get());

        // Render chart
        renderChart('materiChart', 'Materi dibuat', materiData);
        renderChart('tugasChart', 'Tugas dibuat', tugasData);
    </script>
@endsection
