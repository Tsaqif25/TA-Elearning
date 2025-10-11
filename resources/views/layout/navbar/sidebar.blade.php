<div class="sidebar d-flex flex-column p-3">
    <a href="/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
        <i class="fa-solid fa-graduation-cap me-2"></i>
        <span class="fs-5 fw-bold">SMK 2 Padang</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">

        {{-- Admin Menu --}}
        @if (Auth::user()->hasRole('Admin'))
            <li><a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line me-2"></i>Dashboard</a></li>

            <li><a href="{{ route('viewPengajar') }}"
                    class="nav-link {{ Request::is('data-pengajar*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chalkboard-user me-2"></i>Data Pengajar</a></li>

            <li><a href="{{ route('viewMapel') }}" class="nav-link {{ Request::is('data-mapel*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book me-2"></i>Mata Pelajaran</a></li>

            <li><a href="{{ route('viewKelas') }}" class="nav-link {{ Request::is('data-kelas*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-rectangle me-2"></i>Kelas</a></li>

            <li><a href="{{ route('viewSiswa') }}" class="nav-link {{ Request::is('data-siswa*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate me-2"></i>Siswa</a></li>

            <li><a href="{{ route('activity') }}" class="nav-link {{ Request::is('activity') ? 'active' : '' }}">
                    <i class="fas fa-tasks me-2"></i>Activity</a></li>
        @endif

        {{-- Pengajar Menu --}}
        @if (Auth::user()->hasRole('Pengajar'))
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line me-2"></i>Dashboard
                </a>
            </li>

            @foreach ($assignedKelas as $assignedKelasItem)
                <li class="nav-item">
                    <a class="nav-link collapsed d-flex justify-content-between align-items-center" href="#"
                        data-bs-toggle="collapse" data-bs-target="#collapseMapel{{ $loop->iteration }}"
                        aria-expanded="false" aria-controls="collapseMapel{{ $loop->iteration }}">
                        <span><i class="fa-solid fa-book-bookmark me-2"></i>{{ $assignedKelasItem['mapel']->name }}</span>
                        <i class="fa-solid fa-chevron-down small"></i>
                    </a>

                    <div id="collapseMapel{{ $loop->iteration }}" class="collapse" data-bs-parent="#sidebarMenu">
                        <ul class="nav flex-column ms-4">
                            @foreach ($assignedKelasItem['kelas'] as $kelas)
                                <li class="nav-item">
                                    <a href="{{ route('viewKelasMapel', [
                                        'mapel' => $assignedKelasItem['mapel']->id,
                                        'kelas' => $kelas->id,
                                    ]) }}"
                                       class="nav-link py-1 {{ Request::is('kelas-mapel/' . $assignedKelasItem['mapel']->id . '/' . $kelas->id) ? 'active' : '' }}">
                                        <i class="fa-solid fa-users me-2"></i>{{ $kelas->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach
        @endif

        {{-- Siswa Menu --}}
        @unless (Request::routeIs('userUjian'))
            @if (Auth::user()->hasRole('Siswa'))
                @foreach ($assignedKelas as $assignedKelasItem)
                    <li class="nav-item">
                        <a class="nav-link collapsed d-flex justify-content-between align-items-center" href="#"
                           data-bs-toggle="collapse"
                           data-bs-target="#siswaMapel{{ $loop->iteration }}"
                           aria-expanded="false"
                           aria-controls="siswaMapel{{ $loop->iteration }}">
                            <span><i class="fa-solid fa-book-bookmark me-2"></i>{{ $assignedKelasItem['mapel']->name }}</span>
                            <i class="fa-solid fa-chevron-down small"></i>
                        </a>

                        <div id="siswaMapel{{ $loop->iteration }}" class="collapse" data-bs-parent="#sidebarMenu">
                            <ul class="nav flex-column ms-4">
                                @foreach ($assignedKelasItem['kelas'] as $kelas)
                                    <li class="nav-item">
                                        <a href="{{ route('viewKelasMapel', [
                                            'mapel' => $assignedKelasItem['mapel']->id,
                                            'kelas' => $kelas->id,
                                        ]) }}"
                                           class="nav-link py-1 {{ Request::is('kelas-mapel/' . $assignedKelasItem['mapel']->id . '/' . $kelas->id) ? 'active' : '' }}">
                                            <i class="fa-solid fa-users me-2"></i>{{ $kelas->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endforeach
            @endif
        @endunless

    </ul>
    <hr>
    <span class="text-muted small">E-Learning Management System</span>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>