<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Seminar Hasil">
    <x-navbars.sidebar activePage='result-seminars'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Seminar Hasil"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <!-- Enhanced Header -->
                        <div class="card-header bg-gradient-primary p-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-white mb-0">
                                        <i class="fas fa-file-alt me-2"></i>Seminar Hasil
                                    </h2>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Lihat dan kelola status seminar hasil Anda
                                    </p>
                                </div>
                                @php
                                    $supervisions = Auth::user()->mahasiswa->superVisions;
                                    $hasApprovedSupervisor = $supervisions->contains('status', 'approved');
                                    $hasApprovedProposal =
                                        Auth::user()->mahasiswa->seminarProposal?->result === 'success';
                                    $resultSeminar = Auth::user()->mahasiswa->resultSeminar;

                                @endphp
                                @if ($resultSeminar && $resultSeminar->final_score && $resultSeminar->letter_grade)
                                    <a href="{{ route('resultSeminars.exportBeritaAcara', $resultSeminar) }}"
                                        class="btn btn-light">
                                        <i class="fas fa-file-pdf me-1"></i> Export PDF Berita Acara
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body p-4">


                            @if (!$hasApprovedSupervisor)
                                <!-- Alert: No Approved Supervisor -->
                                <div class="" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                                        <div>
                                            <h4 class="alert-heading mb-1">Dosen Pembimbing Belum Disetujui</h4>
                                            <p class="mb-0">Anda belum memiliki dosen pembimbing yang disetujui.
                                                Silakan ajukan permintaan pembimbing terlebih dahulu untuk melanjutkan
                                                ke tahap berikutnya.</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <a href="{{ route('supervisions.index') }}" class="btn btn-primary">
                                        <i class="fas fa-user-plus me-2"></i>Ajukan Dosen Pembimbing
                                    </a>
                                </div>
                            @elseif(!$hasApprovedProposal)
                                <div class="" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                                        <div>
                                            <h4 class="alert-heading mb-1">Seminar Proposal Belum Disetujui</h4>
                                            <p class="mb-0">Anda belum memiliki seminar proposal yang disetujui.
                                                Silakan ajukan seminar proposal terlebih dahulu untuk melanjutkan ke
                                                tahap berikutnya.</p>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            @else
                                @if (!$resultSeminar)
                                    <div class="alert border-0 shadow-sm">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-white p-3 me-3">
                                                <i class="fas fa-info-circle text-info fa-2x"></i>
                                            </div>
                                            <div>
                                                <h4 class="mb-1">Ajukan Seminar Hasil</h4>
                                                <p class="mb-0">Anda sudah memenuhi syarat untuk mengajukan seminar
                                                    hasil.</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#newSubmissionModal">
                                            <i class="fas fa-file-alt me-2"></i>Ajukan Seminar Hasil
                                        </button>
                                    </div>
                                @else
                                    @switch($resultSeminar->status)
                                        @case('pending')
                                            <div class="alert alert-info border-0 shadow-sm">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-white p-3 me-3">
                                                        <i class="fas fa-clock text-info fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="mb-1 text-white">Menunggu Persetujuan</h4>
                                                        <p class="mb-0 text-white">Pengajuan seminar hasil Anda sedang dalam
                                                            proses
                                                            review.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @break

                                        @case('approved')
                                            <div class="alert alert-success border-0 shadow-sm">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-white p-3 me-3">
                                                        <i class="fas fa-check-circle text-success fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="mb-1">Seminar Hasil Disetujui</h4>
                                                        <p class="mb-0">Silakan perhatikan jadwal dan persiapkan diri Anda.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-4">Detail Jadwal Seminar</h5>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <p class="text-muted mb-1">Tanggal</p>
                                                            <p class="fw-bold">
                                                                {{ $resultSeminar->date ? \Carbon\Carbon::parse($resultSeminar->date)->format('d F Y') : 'Belum ditentukan' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="text-muted mb-1">Waktu</p>
                                                            <p class="fw-bold">{{ $resultSeminar->time ?? 'Belum ditentukan' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="text-muted mb-1">Lokasi</p>
                                                            <p class="fw-bold">
                                                                {{ $resultSeminar->location ?? 'Belum ditentukan' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-4">Hasil Seminar</h5>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <p class="text-muted mb-1">Nilai Materi</p>
                                                            <p class="fw-bold">
                                                                {{ $resultSeminar->material_score ?? 'Belum dinilai' }}</p>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p class="text-muted mb-1">Nilai Presentasi</p>
                                                            <p class="fw-bold">
                                                                {{ $resultSeminar->presentation_score ?? 'Belum dinilai' }}</p>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p class="text-muted mb-1">Nilai Akhir</p>
                                                            <p class="fw-bold">
                                                                {{ $resultSeminar->final_score ?? 'Belum dinilai' }}</p>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p class="text-muted mb-1">Nilai Huruf</p>
                                                            <p class="fw-bold">
                                                                {{ $resultSeminar->letter_grade ?? 'Belum dinilai' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @break

                                        @case('rejected')
                                            <div class="alert alert-danger border-0 shadow-sm">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-white p-3 me-3">
                                                        <i class="fas fa-times-circle text-danger fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="mb-1">Pengajuan Ditolak</h4>
                                                        <p class="mb-0">
                                                            {{ $resultSeminar->rejection_reason ?? 'Tidak ada alasan spesifik yang diberikan.' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#resubmitModal">
                                                    <i class="fas fa-redo-alt me-2"></i>Ajukan Ulang
                                                </button>
                                            </div>
                                        @break
                                    @endswitch
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal for New Submission -->
    <div class="modal fade" id="newSubmissionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold text-white">
                        <i class="fas fa-file-alt text-white me-2"></i>Konfirmasi Pengajuan Seminar Hasil
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-question-circle text-primary fs-4"></i>
                        </div>
                        <p class="mb-0 fs-5">Apakah Anda yakin ingin mengajukan seminar hasil?</p>
                    </div>
                    <div class="alert alert-info border-0 d-flex align-items-center">
                        <i class="fas fa-info-circle text-white me-2"></i>
                        <p class="mb-0 text-white">Pastikan Anda telah mempersiapkan semua dokumen yang diperlukan.</p>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form action="{{ route('resultSeminars.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="mahasiswa_id" value="{{ Auth::user()->mahasiswa->id }}">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-paper-plane me-2"></i>Ajukan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Resubmission -->
    <div class="modal fade" id="resubmitModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-white border-0">
                    <h5 class="modal-title fw-bold text-white">
                        <i class="fas fa-redo-alt text-white me-2"></i>Konfirmasi Pengajuan Ulang
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-exclamation-triangle text-warning fs-4"></i>
                        </div>
                        <p class="mb-0 fs-5">Apakah Anda yakin ingin mengajukan ulang seminar hasil?</p>
                    </div>
                    <div class="alert alert-warning border-0 d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <p class="mb-0">Pastikan Anda telah memperbaiki berkas sesuai dengan alasan penolakan
                            sebelumnya.</p>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form action="{{ route('resultSeminars.resubmission') }}" method="POST">
                        @csrf
                        <input type="hidden" name="mahasiswa_id" value="{{ Auth::user()->mahasiswa->id }}">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="fas fa-sync-alt me-2"></i>Ajukan Ulang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<style>
    .empty-state {
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        color: #6c757d;
    }

    .empty-state h4 {
        font-size: 1.75rem;
        font-weight: 600;
    }

    .empty-state p {
        font-size: 1.1rem;
        color: #6c757d;
    }

    .alert {
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

    }

    .card {
        border-radius: 0.75rem;
        border: none;
    }

    .rounded-circle {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .alert-heading {
        font-size: 1.5rem;
        font-weight: 600;
    }

    .card-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #333;
    }

    .modal-content {
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-footer {
        border-top: none;
    }
</style>
