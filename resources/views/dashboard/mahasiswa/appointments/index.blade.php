<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Schedule Page">
    <x-navbars.sidebar activePage='jadwal-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Pengajuan Bimbingan"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <!-- Enhanced Card Header -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-white mb-0">
                                        <i class="fas fa-calendar-check me-2"></i>Jadwal Bimbingan
                                    </h3>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Kelola jadwal konsultasi dengan dosen pembimbing
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Improved Filter Section -->
                        <div class="card-header bg-transparent border-bottom">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-outline">
                                        <i class="fas fa-search position-absolute ps-3 pt-2 text-muted"></i>
                                        <input type="text" id="searchInput" class="form-control ps-5"
                                            placeholder="Cari jadwal...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" id="dateFilter" class="form-control"
                                        placeholder="Filter tanggal">
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select" id="statusFilter">
                                        <option value="">Semua Status</option>
                                        <option value="pending">Menunggu Konfirmasi</option>
                                        <option value="approved">Disetujui</option>
                                        <option value="rejected">Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            @if (Auth::user()->mahasiswa->superVisions->isEmpty())
                                <div class="empty-state text-center py-5">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-user-graduate fa-4x text-primary opacity-50"></i>
                                    </div>
                                    <h5 class="mt-4">Belum Ada Dosen Pembimbing</h5>
                                    <p class="text-muted">Anda belum memiliki dosen pembimbing yang ditugaskan</p>
                                </div>
                            @else
                                @if ($appointments->isEmpty())
                                    <div class="empty-state text-center py-5">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-calendar-alt fa-4x text-primary opacity-50"></i>
                                        </div>
                                        <h5 class="mt-4">Belum Ada Jadwal Bimbingan</h5>
                                        <p class="text-muted mb-4">Mulai ajukan jadwal bimbingan dengan dosen pembimbing
                                            Anda</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center ps-4">Tanggal</th>
                                                    <th class="text-center">Waktu</th>
                                                    <th class="text-center">Dosen</th>
                                                    <th class="text-center">Lokasi</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Logbook</th>
                                                    <th class="text-center pe-4">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($appointments as $appointment)
                                                    @if ($appointment->status == 'approved')
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ \Carbon\Carbon::parse($appointment->schedule->schedule_date)->format('d F Y') }}
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge bg-light text-dark">
                                                                    {{ $appointment->schedule->start_time . ' - ' . $appointment->schedule->end_time }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div
                                                                        class="avatar avatar-sm bg-gradient-primary rounded-circle me-2">
                                                                        {{ strtoupper(substr($appointment->schedule->dosen->user->name, 0, 1)) }}
                                                                    </div>
                                                                    <span>{{ $appointment->schedule->dosen->user->name }}</span>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge bg-success">Approved</span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <i
                                                                        class="fas fa-map-marker-alt text-danger me-2"></i>
                                                                    {{ $appointment->schedule->location ?? 'Belum ditentukan' }}
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                @php
                                                                    $existingLogbook = \App\Models\Logbook::where(
                                                                        'appointment_id',
                                                                        $appointment->id,
                                                                    )->first();
                                                                @endphp

                                                                @if ($existingLogbook)
                                                                    <span
                                                                        class="badge bg-{{ $existingLogbook->status == 'approved' ? 'success' : ($existingLogbook->status == 'rejected' ? 'danger' : 'warning') }}">
                                                                        {{ ucfirst($existingLogbook->status) }}
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-secondary">Belum Ada</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-sm {{ !$existingLogbook || ($existingLogbook && $existingLogbook->status == 'rejected')
                                                                        ? 'btn-primary'
                                                                        : 'btn-secondary disabled' }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#logbookModal-{{ $appointment->id }}"
                                                                    {{ !$existingLogbook || ($existingLogbook && $existingLogbook->status == 'rejected') ? '' : 'disabled' }}>

                                                                    @if (!$existingLogbook)
                                                                        <i class="fas fa-edit me-1"></i>Isi Logbook
                                                                    @elseif ($existingLogbook && $existingLogbook->status == 'rejected')
                                                                        <i class="fas fa-redo me-1"></i>Kirim Ulang
                                                                    @elseif ($existingLogbook && $existingLogbook->status == 'confirmed')
                                                                        <i class="fas fa-check me-1"></i>Logbook
                                                                        Disetujui
                                                                    @else
                                                                        <i class="fas fa-clock me-1"></i>Menunggu
                                                                        Persetujuan
                                                                    @endif
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        <!-- Improved Logbook Modal -->
                                                        <div class="modal fade"
                                                            id="logbookModal-{{ $appointment->id }}" tabindex="-1">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-light">
                                                                        <h5 class="modal-title">
                                                                            <i class="fas fa-book me-2"></i>Isi Logbook
                                                                            Bimbingan
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <form action="{{ route('logbooks.store') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <input type="hidden" name="appointment_id"
                                                                                value="{{ $appointment->id }}">

                                                                            <div class="mb-4">
                                                                                <label class="form-label">Tanggal
                                                                                    Konsultasi</label>
                                                                                <input type="date"
                                                                                    class="form-control"
                                                                                    name="consultation_date"
                                                                                    value="{{ \Carbon\Carbon::parse($appointment->schedule->schedule_date)->format('Y-m-d') }}"
                                                                                    readonly>
                                                                            </div>

                                                                            <div class="mb-4">
                                                                                <label class="form-label">Catatan
                                                                                    Konsultasi</label>
                                                                                <textarea class="form-control" name="notes" rows="4" required
                                                                                    placeholder="Tuliskan hasil konsultasi anda..."></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer bg-light">
                                                                            <button type="button"
                                                                                class="btn btn-light"
                                                                                data-bs-dismiss="modal">
                                                                                Batal
                                                                            </button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">
                                                                                <i class="fas fa-save me-2"></i>Simpan
                                                                                Logbook
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Modal Design -->
        @foreach ($appointments as $appointment)
            <div class="modal fade" id="logbookModal-{{ $appointment->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-primary">
                            <h5 class="modal-title text-white">
                                <i class="fas fa-book-reader me-2"></i>Isi Logbook Bimbingan
                            </h5>
                            <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('logbooks.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                            <div class="modal-body p-4">
                                <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                                    <div class="avatar avatar-lg bg-gradient-primary rounded-circle me-3">
                                        {{ strtoupper(substr($appointment->schedule->dosen->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $appointment->schedule->dosen->user->name }}</h6>
                                        <p class="text-sm text-muted mb-0">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($appointment->schedule->schedule_date) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Catatan Konsultasi</label>
                                    <textarea name="notes" class="form-control" rows="4" placeholder="Tuliskan hasil konsultasi anda..."
                                        required></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <button type="submit" class="btn bg-gradient-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Logbook
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </main>
</x-layout>

@push('styles')
    <style>
        .empty-state {
            padding: 3rem 1.5rem;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .avatar-lg {
            width: 48px;
            height: 48px;
        }

        .icon-shape {
            width: 32px;
            height: 32px;
            background-position: 50%;
            border-radius: .5rem;
        }

        .table thead th {
            font-size: .65rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: .05em;
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .badge {
            text-transform: capitalize;
            padding: .5em .75em;
        }
    </style>
@endpush
