<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Seminar Proposal">
    <x-navbars.sidebar activePage='seminar-proposals'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Seminar Proposal"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        @php
                            $seminarProposal = Auth::user()->mahasiswa->seminarProposal;
                        @endphp
                        <!-- Enhanced Header -->
                        <div class="card-header bg-gradient-primary p-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-white mb-0">
                                        <i class="fas fa-file-alt me-2"></i>Seminar Proposal
                                    </h2>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Lihat dan kelola status seminar proposal Anda
                                    </p>
                                </div>
                                @if ($seminarProposal && $seminarProposal->status === 'approved')
                                    <a href="{{ route('seminarproposals.exportBeritaAcara', $seminarProposal) }}"
                                        class="btn btn-light">
                                        <i class="fas fa-file-pdf me-1"></i> Export PDF Berita Acara
                                    </a>
                                @endif

                            </div>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $supervisions = Auth::user()->mahasiswa->superVisions;
                                $hasApprovedSupervisor = $supervisions->contains('status', 'approved');
                            @endphp

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
                            @else
                                <!-- Tampilkan bagian konten Seminar Proposal -->

                                @if (!$seminarProposal)
                                    <!-- No Seminar Proposal View -->
                                    <div class="empty-state text-center py-5">
                                        <div class="empty-state-icon mb-4">
                                            <i class="fas fa-file-alt fa-4x text-muted"></i>
                                        </div>
                                        <h4 class="text-muted mb-3">Belum Ada Jadwal Seminar Proposal</h4>
                                        <p class="text-muted mb-4">Anda belum memiliki jadwal seminar proposal. Ajukan
                                            seminar proposal Anda sekarang untuk memulai proses.</p>
                                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                            data-bs-target="#newSubmissionModal">
                                            <i class="fas fa-plus me-2"></i>Ajukan Seminar Proposal
                                        </button>
                                    </div>
                                @elseif ($seminarProposal->status === 'pending')
                                    <!-- Pending Status View -->
                                    <div class="" role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock fa-2x me-3"></i>
                                            <div>
                                                <h4 class="alert-heading mb-1">Pengajuan Sedang Diproses</h4>
                                                <p class="mb-0">Anda telah mengirim pengajuan seminar proposal.
                                                    Silakan tunggu hingga proposal Anda disetujui oleh tim akademik.</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><strong>Status:</strong> Menunggu Persetujuan</span>
                                            <span><strong>Tanggal Pengajuan:</strong>
                                                {{ $seminarProposal->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                @elseif ($seminarProposal->status === 'approved')
                                    <!-- Approved Status View -->
                                    <div class="alert alert-success border-0 shadow-sm" role="alert">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-white rounded-circle p-3 me-3">
                                                <i class="fas fa-check-circle text-success fa-2x"></i>
                                            </div>
                                            <div>
                                                <h4 class="alert-heading text-white fw-bold mb-1">Seminar Proposal
                                                    Disetujui</h4>
                                                <p class="text-white mb-0">Selamat! Pengajuan seminar proposal Anda
                                                    telah disetujui.</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card shadow-sm border-0 mt-4">
                                        <div class="card-body p-4">
                                            <h5 class="card-title fw-bold mb-4">
                                                <i class="fas fa-info-circle text-primary me-2"></i>
                                                Detail Seminar Proposal
                                            </h5>

                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                                        <div>
                                                            <div class="text-muted small">Tanggal Seminar</div>
                                                            <strong>{{ $seminarProposal->date ? \Carbon\Carbon::parse($seminarProposal->date)->format('d M Y') : 'Belum ditentukan' }}</strong>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-clock text-primary me-2"></i>
                                                        <div>
                                                            <div class="text-muted small">Waktu</div>
                                                            <strong>{{ $seminarProposal->time ?? 'Belum ditentukan' }}</strong>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                                        <div>
                                                            <div class="text-muted small">Lokasi</div>
                                                            <strong>{{ $seminarProposal->location ?? 'Belum ditentukan' }}</strong>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <hr class="my-4">
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-user-tie text-primary me-2"></i>
                                                        <div>
                                                            <div class="text-muted small">Dosen Pembimbing 1</div>
                                                            @php
                                                                $pembimbing1 = $seminarProposal->proposalAssessments->firstWhere(
                                                                    'type',
                                                                    'pembimbing_1',
                                                                );
                                                            @endphp
                                                            <strong>{{ $pembimbing1 ? $pembimbing1->dosen->user->name : 'Belum ditentukan' }}</strong>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-user-tie text-primary me-2"></i>
                                                        <div>
                                                            <div class="text-muted small">Dosen Pembimbing 2</div>
                                                            @php
                                                                $pembimbing2 = $seminarProposal->proposalAssessments->firstWhere(
                                                                    'type',
                                                                    'pembimbing_2',
                                                                );
                                                            @endphp
                                                            <strong>{{ $pembimbing2 ? $pembimbing2->dosen->user->name : 'Belum ditentukan' }}</strong>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-user-tie text-primary me-2"></i>
                                                        <div>
                                                            <div class="text-muted small">Dosen Penguji</div>
                                                            @php
                                                                $penguji = $seminarProposal->proposalAssessments->firstWhere(
                                                                    'type',
                                                                    'penguji',
                                                                );
                                                            @endphp
                                                            <strong>{{ $penguji ? $penguji->dosen->user->name : 'Belum ditentukan' }}</strong>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <hr class="my-4">
                                                    <div class="row g-4">
                                                        <div class="col-md-4">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-check-circle text-primary me-2"></i>
                                                                <div>
                                                                    <div class="text-muted small">Hasil</div>
                                                                    <strong>
                                                                        @if ($seminarProposal->result)
                                                                            {{ $seminarProposal->result === 'success' ? 'Lulus' : 'Tidak Lulus' }}
                                                                        @else
                                                                            Belum ada hasil
                                                                        @endif
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-calculator text-primary me-2"></i>
                                                                <div>
                                                                    <div class="text-muted small">Nilai Angka</div>
                                                                    <strong>{{ $seminarProposal->numeric_grade ?? 'Belum ada nilai' }}</strong>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-font text-primary me-2"></i>
                                                                <div>
                                                                    <div class="text-muted small">Nilai Huruf</div>
                                                                    <strong>{{ $seminarProposal->letter_grade ?? 'Belum ada nilai' }}</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if ($seminarProposal->notes)
                                                    <div class="col-12">
                                                        <hr class="my-4">
                                                        <div class="bg-light p-3 rounded">
                                                            <h6 class="fw-bold mb-2">
                                                                <i class="fas fa-sticky-note text-primary me-2"></i>
                                                                Catatan
                                                            </h6>
                                                            <p class="mb-0">{{ $seminarProposal->notes }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($seminarProposal->status === 'rejected')
                                    <!-- Rejected Status View -->
                                    <div class="" role="alert">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-times-circle text-danger fa-2x me-3"></i>
                                            <h4 class="alert-heading mb-0">Pengajuan Ditolak</h4>
                                        </div>
                                        <p>Maaf, pengajuan seminar proposal Anda telah ditolak. Silakan periksa alasan
                                            penolakan di bawah ini dan ajukan kembali jika diperlukan.</p>
                                        <hr>
                                        <h6>Alasan Penolakan:</h6>
                                        <p>{{ $seminarProposal->rejection_reason ?? 'Tidak ada alasan spesifik yang diberikan.' }}
                                        </p>
                                        <div class="mt-4">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#resubmitModal">
                                                <i class="fas fa-redo-alt me-2"></i>Ajukan Ulang
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal for New Submission -->
    <div class="modal fade" id="newSubmissionModal" tabindex="-1" aria-labelledby="newSubmissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold text-white" id="newSubmissionModalLabel">
                        <i class="fas fa-file-alt text-white me-2"></i>Konfirmasi Pengajuan Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-question-circle text-primary fs-4"></i>
                        </div>
                        <p class="mb-0 fs-5">Apakah Anda yakin ingin mengajukan seminar proposal baru?</p>
                    </div>
                    <div class="alert alert-info border-0 d-flex align-items-center">
                        <i class="fas fa-info-circle text-white me-2"></i>
                        <p class="mb-0 text-white">Pastikan Anda telah mempersiapkan semua dokumen yang diperlukan
                            sebelum
                            mengajukan.</p>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form action="{{ route('seminarproposals.store') }}" method="POST">
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
    <div class="modal fade" id="resubmitModal" tabindex="-1" aria-labelledby="resubmitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning border-0">
                    <h5 class="modal-title fw-bold text-white" id="resubmitModalLabel">
                        <i class="fas text-white fa-redo-alt me-2"></i>Konfirmasi Pengajuan Ulang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-exclamation-triangle text-warning fs-4"></i>
                        </div>
                        <p class="mb-0 fs-5">Apakah Anda yakin ingin mengajukan ulang seminar proposal yang telah
                            ditolak?</p>
                    </div>
                    <div class="alert alert-warning border-0 d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <p class="mb-0">Pastikan Anda telah memperbaiki proposal sesuai dengan alasan penolakan
                            sebelumnya.</p>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form action="{{ route('seminarproposals.resubmission') }}" method="POST">
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
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
