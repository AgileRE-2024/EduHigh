<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Jadwal Bimbingan">
    <x-navbars.sidebar activePage='jadwal-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Jadwal Bimbingan"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-white mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>Jadwal Bimbingan
                            </h4>
                            <p class="text-white text-sm mb-0 opacity-8">
                                Kelola dan pantau jadwal bimbingan Anda
                            </p>
                        </div>
                        <a href="{{ route('schedules.create') }}"
                            class="btn btn-light text-primary d-flex align-items-center">
                            <i class="fas fa-plus me-2"></i>
                            <span>Buat Jadwal Baru</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if ($schedules->isEmpty())
                        <div class="text-center py-5">
                            <div class="illustration-container mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto" width="120" height="120"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-calendar text-muted">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                                    </rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <h4 class="text-muted mb-3">Tidak ada jadwal bimbingan</h4>
                            <p class="text-muted">Anda belum membuat jadwal bimbingan apapun.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        @if (Auth::user()->role == 'admin')
                                            <th class="text-secondary text-xs font-weight-bold ps-4">Dosen</th>
                                        @endif
                                        <th class="text-secondary text-xs font-weight-bold">Tanggal</th>
                                        <th class="text-secondary text-xs font-weight-bold">Waktu</th>
                                        <th class="text-secondary text-xs font-weight-bold">Tempat</th>
                                        <th class="text-secondary text-xs font-weight-bold">Kuota</th>
                                        <th class="text-secondary text-xs font-weight-bold text-center">Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            @if (Auth::user()->role == 'admin')
                                                <td class="text-sm ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar me-3">
                                                            @if ($schedule->dosen->user->image)
                                                                <img src="{{ asset('storage/images/users/' . $schedule->dosen->user->image) }}"
                                                                    class="rounded-circle" width="40" height="40"
                                                                    alt="Dosen">
                                                            @else
                                                                <div
                                                                    class="avatar avatar-xl bg-gradient-primary rounded-circle text-white d-flex align-items-center justify-content-center">
                                                                    {{ strtoupper(substr($schedule->dosen->user->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 text-sm">{{ $schedule->dosen->user->name }}
                                                            </h6>
                                                            <p class="text-xs text-muted mb-0">
                                                                {{ $schedule->dosen->user->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                            <td class="text-sm">
                                                <span class="badge bg-gradient-primary">
                                                    {{ \Carbon\Carbon::parse($schedule->schedule_date)->translatedFormat('d F Y') }}
                                                </span>
                                            </td>
                                            <td class="text-sm">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-clock me-2 text-primary"></i>
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="text-sm">
                                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                                {{ $schedule->location }}
                                            </td>
                                            <td class="text-sm">
                                                <span
                                                    class="badge {{ $schedule->quota > 3 ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $schedule->quota }} Slot
                                                </span>
                                            </td>
                                            <td class="text-sm text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('schedules.show', $schedule) }}"
                                                        class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                                        title="Lihat Detail">
                                                        <i class="fas fa-eye"></i> Lihat Detail
                                                    </a>
                                                    <a href="{{ route('schedules.edit', $schedule) }}"
                                                        class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                        title="Edit Jadwal">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $schedule->id }}"
                                                        title="Hapus Jadwal">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </div>


                                                {{-- Delete Confirmation Modal --}}
                                                <div class="modal fade" id="deleteModal{{ $schedule->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Konfirmasi Hapus Jadwal</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus jadwal ini?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <form
                                                                    action="{{ route('schedules.destroy', $schedule->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if ($schedules->hasPages())
                            <div class="card-footer d-flex justify-content-center">
                                {{ $schedules->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </main>
</x-layout>
