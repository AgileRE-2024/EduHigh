<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Review Seminar Proposal">
    <x-navbars.sidebar activePage='review-sempro'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Review Seminar Proposal"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-white mb-0">
                                        <i class="fas fa-tasks me-2" aria-hidden="true"></i>Review Seminar Proposal
                                    </h2>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Kelola pengajuan seminar proposal mahasiswa bimbingan Anda
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">NIM</th>
                                            <th scope="col">Nama Mahasiswa</th>
                                            <th scope="col">Tanggal Pengajuan</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($seminarProposalReviews as $proposal)
                                            <tr>
                                                <td>{{ $proposal->seminarProposal->mahasiswa->nim }}</td>
                                                <td>{{ $proposal->seminarProposal->mahasiswa->user->name }}</td>
                                                <td>{{ $proposal->seminarProposal->created_at->format('d M Y') }}</td>
                                                <td>
                                                    @switch($proposal->status)
                                                        @case('pending')
                                                            <span class="badge bg-warning">Menunggu Review</span>
                                                        @break

                                                        @case('approved')
                                                            <span class="badge bg-success">Disetujui</span>
                                                        @break

                                                        @case('rejected')
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <button id="reviewButton{{ $proposal->id }}"
                                                        class="btn btn-sm {{ $proposal->seminarProposal->status == 'approved' ? 'btn-secondary' : 'btn-primary' }} me-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#reviewModal{{ $proposal->id }}"
                                                        {{ $proposal->seminarProposal->status == 'approved' ? 'disabled' : '' }}>
                                                        <i class="fas fa-eye me-1"></i>Review
                                                    </button>

                                                </td>
                                            </tr>

                                            <!-- Review Modal -->
                                            <div class="modal fade" id="reviewModal{{ $proposal->id }}" tabindex="-1"
                                                aria-labelledby="reviewModalLabel{{ $proposal->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow">
                                                        <div
                                                            class="modal-header {{ $proposal->seminarProposal->status == 'approved' ? 'bg-secondary' : 'bg-info' }} text-white border-0">
                                                            <h5 class="modal-title"
                                                                id="reviewModalLabel{{ $proposal->id }}">
                                                                <i class="fas fa-file-alt me-2"
                                                                    aria-hidden="true"></i>Review Proposal
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('seminar-proposal-review') }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body p-4">
                                                                @if ($proposal->seminarProposal->status == 'approved')
                                                                    <div class="alert alert-warning" role="alert">
                                                                        <i class="fas fa-exclamation-triangle me-2"
                                                                            aria-hidden="true"></i>
                                                                        Review tidak dapat diubah karena seminar
                                                                        proposal telah disetujui
                                                                    </div>
                                                                @endif

                                                                <div class="mb-3">
                                                                    <h6 class="fw-bold">Detail Mahasiswa:</h6>
                                                                    <p class="mb-1">Nama:
                                                                        {{ $proposal->seminarProposal->mahasiswa->user->name }}
                                                                    </p>
                                                                    <p class="mb-1">NIM:
                                                                        {{ $proposal->seminarProposal->mahasiswa->nim }}
                                                                    </p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status{{ $proposal->id }}"
                                                                        class="form-label">Status Review</label>
                                                                    <select name="status"
                                                                        id="status{{ $proposal->id }}"
                                                                        class="form-select" required
                                                                        {{ $proposal->seminarProposal->status == 'approved' ? 'disabled' : '' }}>
                                                                        <option value="">Pilih Status Review
                                                                        </option>
                                                                        <option value="approved"
                                                                            {{ $proposal->status == 'approved' ? 'selected' : '' }}>
                                                                            Setujui</option>
                                                                        <option value="rejected"
                                                                            {{ $proposal->status == 'rejected' ? 'selected' : '' }}>
                                                                            Tolak</option>
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" name="review_id"
                                                                    value="{{ $proposal->id }}">
                                                                <input type="hidden" name="seminar_proposal_id"
                                                                    value="{{ $proposal->seminarProposal->id }}">
                                                                <div class="mb-3">
                                                                    <label for="comment{{ $proposal->id }}"
                                                                        class="form-label">Komentar</label>
                                                                    <textarea name="comment" id="comment{{ $proposal->id }}" class="form-control" rows="4"
                                                                        {{ $proposal->seminarProposal->status == 'approved' ? 'disabled' : '' }}>{{ $proposal->comment }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                @if ($proposal->seminarProposal->status != 'approved')
                                                                    <button type="submit" class="btn btn-info">
                                                                        <i class="fas fa-paper-plane me-2"
                                                                            aria-hidden="true"></i>Kirim Review
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <i class="fas fa-inbox fa-3x text-muted mb-3"
                                                                aria-hidden="true"></i>
                                                            <p class="mb-0">Belum ada pengajuan seminar proposal</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </x-layout>

    <style>
        button[disabled] {
            pointer-events: none;
            opacity: 0.65;
        }

        .modal-open {
            overflow: hidden;
        }

        .modal-open .modal {
            overflow-x: hidden;
            overflow-y: auto;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Loop untuk tombol yang memiliki id dengan reviewButton
            @foreach ($seminarProposalReviews as $proposal)
                var reviewButton = document.getElementById('reviewButton{{ $proposal->id }}');
                if (reviewButton && reviewButton.hasAttribute('disabled')) {
                    reviewButton.addEventListener('click', function(e) {
                        e.preventDefault(); // Mencegah aksi klik
                        e.stopPropagation(); // Mencegah propagasi event
                        alert("Review tidak dapat diubah karena proposal sudah disetujui.");
                    });
                }
            @endforeach
        });
    </script>
