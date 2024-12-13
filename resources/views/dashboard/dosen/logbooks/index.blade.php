<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Logbook Review">
    <x-navbars.sidebar activePage='pengajuan-logbook'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Review Logbook"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-radius-xl">
                        <!-- Header with Search and Filters -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h3 class="text-white mb-0">
                                        <i class="fas fa-book-reader me-2"></i>Review Logbook Mahasiswa
                                    </h3>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Evaluasi dan berikan feedback untuk logbook mahasiswa
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Table Content -->
                        <div class="card-body p-0">
                            @if ($logbooks->isEmpty())
                                <div class="text-center py-5">
                                    <h4 class="text-muted">Belum Ada Logbook</h4>
                                    <p class="text-muted">Belum ada logbook yang perlu direview saat ini</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="text-center ps-4">Mahasiswa</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Persentasi</th>
                                                <th class="text-center">Catatan</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-end pe-4">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($logbooks as $logbook)
                                                <tr id="logbook-row-{{ $logbook->id }}">
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="avatar avatar-sm bg-gradient-primary rounded-circle me-3">
                                                                {{ strtoupper(substr($logbook->superVision->mahasiswa->user->name, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">
                                                                    {{ $logbook->superVision->mahasiswa->user->name }}
                                                                </h6>
                                                                <span
                                                                    class="text-muted text-sm">{{ $logbook->superVision->mahasiswa->nim }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="text-sm">
                                                            {{ \Carbon\Carbon::parse($logbook->consultation_date)->format('d M Y') }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="text-sm">
                                                            {{ $logbook->percentage }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm mb-0 text-wrap" style="max-width: 300px;">
                                                            {{ Str::limit($logbook->notes, 100) }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        @switch($logbook->status)
                                                            @case('approved')
                                                                <span
                                                                    class="badge bg-success-subtle text-success">Disetujui</span>
                                                            @break

                                                            @case('rejected')
                                                                <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                                                            @break

                                                            @default
                                                                <span
                                                                    class="badge bg-warning-subtle text-warning">Pending</span>
                                                        @endswitch
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#logbookModal-{{ $logbook->id }}">
                                                            <i class="fas fa-edit me-1"></i>Review
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="px-4 py-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-sm text-muted mb-0">
                                            Showing {{ $logbooks->firstItem() }} to {{ $logbooks->lastItem() }} of
                                            {{ $logbooks->total() }} entries
                                        </p>
                                        {{ $logbooks->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Modal -->
        @foreach ($logbooks as $logbook)
            <div class="modal fade" id="logbookModal-{{ $logbook->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title text-white">Review Logbook</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Student Info -->
                            <div class="border-bottom pb-3 mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-uppercase text-muted mb-2">Informasi Mahasiswa</h6>
                                        <h5 class="mb-1">{{ $logbook->superVision->mahasiswa->user->name }}</h5>
                                        <p class="mb-0 text-muted">{{ $logbook->superVision->mahasiswa->nim }}</p>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <h6 class="text-uppercase text-muted mb-2">Tanggal Konsultasi</h6>
                                        <h5 class="mb-1">
                                            {{ \Carbon\Carbon::parse($logbook->consultation_date)->format('d F Y') }}
                                        </h5>
                                        <p class="mb-0 text-muted">
                                            {{ \Carbon\Carbon::parse($logbook->consultation_date)->format('l') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Consultation Notes -->
                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted mb-3">Catatan Konsultasi</h6>
                                <div class="bg-light rounded p-3">
                                    {{ $logbook->notes }}
                                </div>
                            </div>

                            <!-- Review Form -->
                            <form id="reviewForm-{{ $logbook->id }}"
                                action="{{ route('logbooks.confirmLogbook', $logbook) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label text-muted">Komentar Dosen</label>
                                    <textarea class="form-control" name="comments" rows="3" placeholder="Berikan komentar untuk mahasiswa...">{{ $logbook->comments }}</textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" form="reviewForm-{{ $logbook->id }}" name="status"
                                value="rejected" class="btn btn-danger">
                                <i class="fas fa-times me-1"></i>Tolak
                            </button>
                            <button type="submit" form="reviewForm-{{ $logbook->id }}" name="status"
                                value="confirmed" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>Setujui
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </main>
</x-layout>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('tbody tr');

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();

                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Filter functionality
            const filterButtons = document.querySelectorAll('[data-status]');
            const currentFilter = document.getElementById('currentFilter');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const status = this.dataset.status;
                    currentFilter.textContent = this.textContent;

                    tableRows.forEach(row => {
                        if (status === 'all') {
                            row.style.display = '';
                        } else {
                            const rowStatus = row.querySelector('.badge').textContent
                                .toLowerCase();
                            row.style.display = rowStatus.includes(status.toLowerCase()) ?
                                '' : 'none';
                        }
                    });
                });
            });

            // Row hover effect
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.classList.add('bg-light');
                });
                row.addEventListener('mouseleave', function() {
                    this.classList.remove('bg-light');
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .avatar {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1);
        }
    </style>
@endpush
