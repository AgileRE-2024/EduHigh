<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Seminar Proposal">
    <x-navbars.sidebar activePage='seminar-proposal'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Seminar Proposal"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-white mb-0">
                                        <i class="fas fa-chalkboard-teacher me-2"></i>Daftar Seminar Proposal
                                    </h2>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Daftar seminar proposal mahasiswa yang Anda uji
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if ($seminarProposals->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5>Belum ada seminar proposal</h5>
                                    <p class="text-muted">Anda belum ditugaskan sebagai penguji seminar proposal</p>
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
                                            @foreach ($seminarProposals as $seminarproposal)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-0">
                                                                {{ $seminarproposal->mahasiswa->user->name }}</h6>
                                                            <span
                                                                class="text-secondary text-xs">{{ $seminarproposal->mahasiswa->nim }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span>{{ \Carbon\Carbon::parse($seminarproposal->date)->format('d M Y') }}</span>
                                                            <span
                                                                class="text-secondary text-xs">{{ $seminarproposal->time }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $seminarproposal->location }}</td>
                                                    <td>
                                                        @php
                                                            $assessment = $seminarproposal->proposalAssessments
                                                                ->where('dosen_id', Auth::user()->dosen->id)
                                                                ->first();
                                                            $role = $assessment ? $assessment->type : '-';
                                                        @endphp
                                                        <span
                                                            class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $role)) }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($seminarproposal->numeric_grade)
                                                            <div class="d-flex align-items-center">
                                                                <span
                                                                    class="me-2">{{ $seminarproposal->numeric_grade }}</span>
                                                                <span
                                                                    class="badge bg-primary">{{ $seminarproposal->letter_grade }}</span>
                                                            </div>
                                                        @else
                                                            <span class="text-secondary text-xs">Belum dinilai</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($role == 'pembimbing_1' || $role == 'pembimbing_2' || $role == 'penguji')
                                                            <a href="{{ route('seminarproposal.evaluation', $seminarproposal->id) }}"
                                                                class="btn btn-warning btn-sm"
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
