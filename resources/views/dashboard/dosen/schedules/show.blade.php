<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Schedule Page">
    <x-navbars.sidebar activePage='jadwal-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Detail Jadwal Bimbingan"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="text-white mb-0">
                                        <i class="fas fa-calendar-alt me-2"></i>Detail Jadwal Bimbingan

                                    </h4>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Lihat detail jadwal bimbingan yang telah Anda buat
                                    </p>
                                </div>
                                <a href="{{ route('schedules.index') }}"
                                    class="btn btn-light text-primary d-flex align-items-center">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    <span>Kembali</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <h4 class="mb-4">Informasi Jadwal Bimbingan</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th><i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-clock me-2 text-primary"></i>Waktu Mulai</th>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-clock me-2 text-primary"></i>Waktu Selesai</th>
                                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-map-marker-alt me-2 text-primary"></i>Tempat</th>
                                    <td>{{ $schedule->location }}</td>
                                </tr>
                                <tr>
                                    <th><i class="fas fa-users me-2 text-primary"></i>Kuota</th>
                                    <td>{{ $schedule->quota }}</td>
                                </tr>
                            </table>

                            <h4 class="mt-5">Daftar Mahasiswa</h4>
                            @if ($appointments->isEmpty())
                                <p class="card-text">Belum ada mahasiswa yang mendaftar.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th><i class="fas fa-user-graduate me-2 text-primary"></i>Nama Mahasiswa
                                                </th>
                                                <th><i class="fas fa-file-alt me-2 text-primary"></i>Judul Proposal</th>
                                                <th><i class="fas fa-calendar-check me-2 text-primary"></i>Tanggal
                                                    Pendaftaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($appointments as $appointment)
                                                <tr>
                                                    <td>{{ $appointment->mahasiswa->user->name }}</td>
                                                    <td>{{ ucfirst($appointment->mahasiswa->user->proposal->titles->first()->name) }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($appointment->created_at)->format('d-m-Y H:i') }}
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
    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .table th i,
    .table td i {
        margin-right: 0.5rem;
    }

    .btn-outline-light {
        color: #fff;
        border-color: #fff;
    }

    .btn-outline-light:hover {
        color: #000;
        background-color: #fff;
        border-color: #fff;
    }
</style>
