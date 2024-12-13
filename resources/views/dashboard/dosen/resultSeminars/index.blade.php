<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Seminar Hasil">
    <x-navbars.sidebar activePage='seminar-hasil'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Seminar Hasil"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-white mb-0">
                                        <i class="fas fa-chalkboard-teacher me-2"></i>Daftar Seminar Hasil
                                    </h2>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Daftar seminar hasil mahasiswa yang Anda uji
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if ($resultSeminars->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5>Belum ada seminar hasil</h5>
                                    <p class="text-muted">Anda belum ditugaskan sebagai penguji seminar hasil</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Mahasiswa</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Jadwal</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Lokasi</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status Anda</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nilai</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($resultSeminars as $resultSeminar)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-0">
                                                                {{ $resultSeminar->mahasiswa->user->name }}</h6>
                                                            <span
                                                                class="text-secondary text-xs">{{ $resultSeminar->mahasiswa->nim }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span>{{ \Carbon\Carbon::parse($resultSeminar->date)->format('d M Y') }}</span>
                                                            <span
                                                                class="text-secondary text-xs">{{ $resultSeminar->time }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $resultSeminar->location }}</td>
                                                    <td>
                                                        @php
                                                            $assessment = $resultSeminar->resultAssessments
                                                                ->where('dosen_id', Auth::user()->dosen->id)
                                                                ->first();
                                                            $role = $assessment ? $assessment->type : '-';
                                                        @endphp
                                                        <span
                                                            class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $role)) }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($resultSeminar->numeric_grade)
                                                            <div class="d-flex align-items-center">
                                                                <span
                                                                    class="me-2">{{ $resultSeminar->numeric_grade }}</span>
                                                                <span
                                                                    class="badge bg-primary">{{ $resultSeminar->letter_grade }}</span>
                                                            </div>
                                                        @else
                                                            <span class="text-secondary text-xs">Belum dinilai</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $assessment = $resultSeminar
                                                                ->resultAssessments()
                                                                ->where('dosen_id', Auth::user()->dosen->id)
                                                                ->first();
                                                        @endphp
                                                        @if ($role == 'pembimbing_1' || $role == 'pembimbing_2' || $role == 'penguji_1' || $role == 'penguji_2')
                                                            <a href="{{ route('resultSeminars.evaluation', $resultSeminar->id) }}"
                                                                class="btn btn-warning btn-sm {{ $assessment && $assessment->is_submitted ? 'disabled' : '' }}"
                                                                title="Evaluate Proposal">
                                                                <i class="fas fa-star me-1"></i> Evaluate
                                                            </a>
                                                        @else
                                                            <span class="text-muted">No action available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
