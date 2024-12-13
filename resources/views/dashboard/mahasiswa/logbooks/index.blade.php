<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Logbook Page">
    <x-navbars.sidebar activePage='log-book'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Logbook Konsultasi"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <!-- Card Header -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="text-white mb-0">
                                        <i class="fas fa-book me-2"></i>Logbook Konsultasi
                                    </h4>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Riwayat konsultasi yang telah disetujui
                                    </p>
                                    <a href="{{ route('logbooks.create') }}"
                                        class="btn btn-light hover:shadow-lg transition-all duration-300 mt-3">
                                        <i class="fas fa-plus me-2"></i>
                                        <span>Tambah Logbook</span>
                                    </a>

                                </div>
                                <div>
                                    @if (Auth::user()->mahasiswa->superVisions->first()->status == 'approved')
                                        <form action="{{ route('logbooks.export') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-light hover:shadow-lg transition-all duration-300">
                                                <i class="fas fa-print me-2"></i>
                                                <span>Cetak Logbook</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Table Content with Loading State -->
                        <div class="position-relative">
                            <div id="loadingOverlay"
                                class="position-absolute w-100 h-100 bg-white bg-opacity-80 d-none">
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                @if (!Auth::user()->proposal)
                                    <div class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon mb-4">
                                                <i class="fas fa-file-alt fa-4x text-muted"></i>
                                            </div>
                                            <h5 class="text-muted">Belum Ada Proposal</h5>
                                            <p class="text-sm text-muted mb-0">
                                                Anda belum memiliki proposal. Silakan buat proposal terlebih dahulu.
                                            </p>
                                            <a href="{{ route('proposals.create') }}" class="btn btn-primary mt-3">
                                                <i class="fas fa-plus me-2"></i>Buat Proposal
                                            </a>
                                        </div>
                                    </div>
                                @elseif (Auth::user()->mahasiswa->superVisions->isEmpty() ||
                                        Auth::user()->mahasiswa->superVisions->first()->status != 'approved')
                                    <div class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon mb-4">
                                                <i class="fas fa-user-plus fa-4x text-muted"></i>
                                            </div>
                                            <h5 class="text-muted">Belum Ada Dosen Pembimbing</h5>
                                            <p class="text-sm text-muted mb-0">
                                                Anda belum memiliki dosen pembimbing. Silakan ajukan permintaan
                                                pembimbing.
                                            </p>
                                            <a href="{{ route('supervisions.index') }}" class="btn btn-primary mt-3">
                                                <i class="fas fa-user-plus me-2"></i>Ajukan Dosen Pembimbing
                                            </a>
                                        </div>
                                    </div>
                                @elseif ($logbooks->isEmpty())
                                    <div class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon mb-4">
                                                <i class="fas fa-book-open fa-4x text-muted"></i>
                                            </div>
                                            <h5 class="text-muted">Belum Ada Logbook</h5>
                                            <p class="text-sm text-muted mb-0">
                                                Anda belum memiliki catatan konsultasi yang disetujui
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div class="card">
                                        <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                            <h3 class="card-title font-weight-bolder text-primary text-gradient">Logbook
                                                Entries</h3>
                                        </div>
                                        <div class="card-body pt-2">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                                No.</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Tanggal</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Dosen</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Persentase</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Catatan</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                                Status</th>
                                                            <th
                                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                                Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($logbooks as $index => $logbook)
                                                            <tr>
                                                                <td class="text-center">
                                                                    <p class="text-sm font-weight-bold mb-0">
                                                                        {{ $loop->iteration }}</p>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex px-2 py-1">
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center">
                                                                            <h6 class="mb-0 text-sm">
                                                                                {{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex px-2 py-1">
                                                                        <div
                                                                            class="avatar avatar-sm me-3 bg-gradient-secondary rounded-circle">
                                                                            {{ strtoupper(substr($logbook->superVision->dosen->user->name, 0, 1)) }}
                                                                        </div>
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center">
                                                                            <h6 class="mb-0 text-sm">
                                                                                {{ $logbook->superVision->dosen->user->name }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0">
                                                                        {{ $logbook->percentage }}</p>
                                                                </td>
                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0">
                                                                        {{ Str::limit($logbook->notes, 50) }}</p>
                                                                </td>
                                                                <td class="align-middle text-center text-sm">
                                                                    @switch($logbook->status)
                                                                        @case('confirmed')
                                                                            <span
                                                                                class="badge badge-sm bg-gradient-success">Disetujui</span>
                                                                        @break

                                                                        @case('pending')
                                                                            <span
                                                                                class="badge badge-sm bg-gradient-warning">Pending</span>
                                                                        @break

                                                                        @case('rejected')
                                                                            <span
                                                                                class="badge badge-sm bg-gradient-danger">Ditolak</span>
                                                                        @break

                                                                        @default
                                                                            <span
                                                                                class="badge badge-sm bg-gradient-secondary">Tidak
                                                                                Diketahui</span>
                                                                    @endswitch
                                                                </td>
                                                                <td class="align-middle text-center">
                                                                    <div class="btn-group" role="group">
                                                                        <a href="{{ route('logbooks.show', $logbook) }}"
                                                                            class="btn btn-sm bg-gradient-info me-2">
                                                                            <i class="fas fa-eye me-1"></i> Show
                                                                        </a>
                                                                        <a href="{{ route('logbooks.edit', $logbook) }}"
                                                                            class="btn btn-sm bg-gradient-warning {{ $logbook->status == 'confirmed' ? 'disabled' : '' }}"
                                                                            {{ $logbook->status == 'approved' ? 'aria-disabled=true' : '' }}>
                                                                            <i class="fas fa-edit me-1"></i> Edit
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="border-top px-4 py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="text-sm text-muted mb-0">
                                                Showing {{ $logbooks->firstItem() }} to {{ $logbooks->lastItem() }} of
                                                {{ $logbooks->total() }} entries
                                            </p>
                                            {{ $logbooks->links() }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</x-layout>

@push('styles')
    <style>
        .empty-state-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            background: #f8f9fa;
            border-radius: 50%;
        }

        .avatar {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .avatar-lg {
            width: 48px;
            height: 48px;
        }

        .icon-shape {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
        }

        @media print {

            .sidebar,
            .navbar,
            .card-header,
            .modal,
            .btn,
            .pagination {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
            }

            .table {
                border: 1px solid #dee2e6;
            }

            .table td,
            .table th {
                border: 1px solid #dee2e6;
            }
        }
    </style>
@endpush
