```blade
<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Pengajuan Bimbingan">
    <x-navbars.sidebar activePage='pengajuan-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Pengajuan Bimbingan"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <!-- Card Header with Summary and Actions -->
                        <div
                            class="card-header bg-gradient-primary pb-0 pt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="text-white mb-0">
                                    <i class="fas fa-calendar-check me-2"></i>Pengajuan Bimbingan
                                </h4>
                                <p class="text-white text-sm opacity-8 mb-2">
                                    Kelola dan tindak lanjuti pengajuan bimbingan mahasiswa Anda
                                </p>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body px-0 pb-2">
                            @if ($appointments->isEmpty())
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                    <p class="text-muted">Tidak ada pengajuan bimbingan</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Mahasiswa</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Jadwal</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($appointments as $appointment)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">
                                                                    {{ $appointment->mahasiswa->user->name }}</h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $appointment->mahasiswa->nim }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ \Carbon\Carbon::parse($appointment->schedule->schedule_date)->format('d-m-Y') }}
                                                        </p>
                                                        <p class="text-xs text-secondary mb-0">
                                                            {{ $appointment->schedule->start_time }} -
                                                            {{ $appointment->schedule->end_time }}
                                                        </p>
                                                        <p class="text-xs text-secondary mb-0">
                                                            <i
                                                                class="fas fa-map-marker-alt me-1"></i>{{ $appointment->schedule->location ?? 'Belum ditentukan' }}
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        @php
                                                            $statusBadge = [
                                                                'pending' => 'warning',
                                                                'approved' => 'success',
                                                                'rejected' => 'danger',
                                                            ][$appointment->status];
                                                        @endphp
                                                        <span class="badge badge-sm bg-gradient-{{ $statusBadge }}">
                                                            {{ ucfirst($appointment->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <div class="btn-group" role="group">
                                                            <form
                                                                action="{{ route('appointments.update', $appointment) }}"
                                                                method="POST" style="display: inline;" class="me-1">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="approved">
                                                                <input type="hidden" name="mahasiswa_id"
                                                                    value="{{ $appointment->mahasiswa->id }}">
                                                                <input type="hidden" name="schedule_id"
                                                                    value="{{ $appointment->schedule->id }}">
                                                                <button type="submit" class="btn btn-success btn-sm"
                                                                    @if ($appointment->status !== 'pending') disabled @endif>
                                                                    Setujui
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#rejectModal{{ $appointment->id }}"
                                                                @if ($appointment->status !== 'pending') disabled @endif>
                                                                Tolak
                                                            </button>
                                                        </div>

                                                        <!-- Modal Tolak -->
                                                        <div class="modal fade" id="rejectModal{{ $appointment->id }}"
                                                            tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Alasan Penolakan</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('appointments.update', $appointment) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="status"
                                                                                value="rejected">
                                                                            <div class="mb-3">
                                                                                <label for="reason"
                                                                                    class="form-label">Alasan
                                                                                    Penolakan</label>
                                                                                <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                                                                            </div>
                                                                            <input type="hidden" name="mahasiswa_id"
                                                                                value="{{ $appointment->mahasiswa->id }}">
                                                                            <input type="hidden" name="schedule_id"
                                                                                value="{{ $appointment->schedule->id }}">
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Kirim
                                                                                    Alasan</button>
                                                                            </div>
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</x-layout>

<style>
    .table-responsive {
        max-height: 500px;
        overflow-y: auto;
    }
</style>
```
