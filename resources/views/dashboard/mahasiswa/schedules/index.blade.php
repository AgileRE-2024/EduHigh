<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Schedule Page">
    <x-navbars.sidebar activePage='pengajuan-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Pengajuan Bimbingan"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <!-- Enhanced Card Header -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h3 class="text-white mb-0">
                                        <i class="fas fa-calendar-alt me-2"></i>Jadwal Bimbingan
                                    </h3>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Pilih jadwal bimbingan yang tersedia
                                    </p>
                                </div>
                            </div>

                        </div>

                        <!-- Search and Filter Section -->
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
                            </div>
                        </div>

                        <div class="card-body p-0">
                            @if (Auth::user()->mahasiswa->superVisions->isEmpty())
                                <div class="empty-state text-center py-5">
                                    <div class="empty-state-icon mb-4">
                                        <i class="fas fa-user-graduate fa-4x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">Belum Ada Dosen Pembimbing</h5>
                                    <p class="text-sm text-muted mb-0">
                                        Anda belum memiliki dosen pembimbing yang ditugaskan
                                    </p>
                                </div>
                            @else
                                @if ($schedules->isEmpty())
                                    <div class="empty-state text-center py-5">
                                        <div class="empty-state-icon mb-4">
                                            <i class="fas fa-calendar fa-4x text-muted"></i>
                                        </div>
                                        <h5 class="text-muted">Tidak Ada Jadwal Tersedia</h5>
                                        <p class="text-sm text-muted mb-0">
                                            Belum ada jadwal bimbingan yang tersedia saat ini
                                        </p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Dosen</th>
                                                    <th class="ps-4">Tanggal</th>
                                                    <th>Waktu</th>
                                                    <th>Lokasi</th>
                                                    <th class="text-center">Kuota</th>
                                                    <th class="text-center">Tersisa</th>
                                                    <th class="text-end pe-4">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($schedules as $schedule)
                                                    <tr>
                                                        <td class="ps-4">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Periksa apakah gambar dosen ada -->
                                                                @if ($schedule->dosen->user->image)
                                                                    <img src="{{ asset('storage/images/users/' . $schedule->dosen->user->image) }}"
                                                                        class="avatar avatar-sm rounded-circle me-2"
                                                                        alt="{{ $schedule->dosen->user->name }}">
                                                                @else
                                                                    <!-- Jika gambar tidak ada, tampilkan inisial -->
                                                                    <div
                                                                        class="avatar avatar-sm bg-gradient-primary rounded-circle me-2">
                                                                        {{ strtoupper(substr($schedule->dosen->user->name, 0, 1)) }}
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <h6 class="mb-0">
                                                                        {{ $schedule->dosen->user->name }}
                                                                    </h6>
                                                                    <span class="text-sm text-secondary">
                                                                        {{ $schedule->dosen->user->email }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                {{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d M Y') }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-light text-dark">
                                                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                                                {{ $schedule->location ?? 'Belum ditentukan' }}
                                                            </div>
                                                        </td>
                                                        <td class="text-center">{{ $schedule->quota }}</td>
                                                        <td class="text-center">
                                                            <span
                                                                class="badge bg-{{ $schedule->remaining_quota > 0 ? 'success' : 'danger' }}">
                                                                {{ $schedule->remaining_quota }}
                                                            </span>
                                                        </td>
                                                        <td class="text-end pe-4">
                                                            @php
                                                                $hasActiveAppointment = $schedule->appointments
                                                                    ->where('mahasiswa_id', Auth::user()->mahasiswa->id)
                                                                    ->whereIn('status', ['pending', 'approved'])
                                                                    ->isNotEmpty();
                                                            @endphp
                                                            <form action="{{ route('appointments.store') }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="schedule_id"
                                                                    value="{{ $schedule->id }}">
                                                                <input type="hidden" name="mahasiswa_id"
                                                                    value="{{ Auth::user()->mahasiswa->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-sm {{ $hasActiveAppointment || $schedule->remaining_quota <= 0 ? 'btn-secondary' : 'btn-primary' }}"
                                                                    {{ $hasActiveAppointment || $schedule->remaining_quota <= 0 ? 'disabled' : '' }}>
                                                                    <i
                                                                        class="fas {{ $hasActiveAppointment ? 'fa-check' : 'fa-plus' }} me-1"></i>
                                                                    {{ $hasActiveAppointment ? 'Sudah Terdaftar' : 'Buat Janji' }}
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
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
