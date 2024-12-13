```blade
<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Edit Schedule Page">
    <x-navbars.sidebar activePage='jadwal-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Jadwal Bimbingan"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-lg">
                        <!-- Card Header -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="text-white mb-0">
                                        <i class="fas fa-calendar-edit me-2"></i>Edit Jadwal Bimbingan
                                    </h4>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Perbarui jadwal bimbingan yang sudah ada
                                    </p>
                                </div>
                                <a href="{{ route('schedules.index') }}" class="btn btn-outline-light">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <!-- Display validation errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><i class="fas fa-exclamation-circle me-2"></i>Terjadi kesalahan!</strong>
                                    Silakan periksa inputan Anda.
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li class="text-sm">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Schedule Edit Form -->
                            <form action="{{ route('schedules.update', $schedule) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Tanggal Bimbingan -->
                                <div class="mb-4">
                                    <label for="schedule_date" class="form-label">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal Bimbingan
                                    </label>
                                    <input type="date" name="schedule_date" id="schedule_date" class="form-control"
                                        value="{{ old('schedule_date', $schedule->schedule_date) }}" required>
                                </div>

                                <!-- Waktu  -->
                                <div class="mb-4 d-flex justify-content-between">
                                    <div class="flex-grow-1 me-2">
                                        <label for="start_time" class="form-label">
                                            <i class="fas fa-clock me-2 text-primary"></i>Waktu Mulai
                                        </label>
                                        <input type="time" name="start_time" id="start_time" class="form-control"
                                            value="{{ old('start_time', $schedule->start_time) }}" required>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <label for="end_time" class="form-label">
                                            <i class="fas fa-clock me-2 text-primary"></i>Waktu Selesai
                                        </label>
                                        <input type="time" name="end_time" id="end_time" class="form-control"
                                            value="{{ old('end_time', $schedule->end_time) }}" required>
                                    </div>
                                </div>

                                <!-- Tempat -->
                                <div class="mb-4">
                                    <label for="location" class="form-label">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>Tempat
                                    </label>
                                    <input type="text" name="location" id="location" class="form-control"
                                        placeholder="Masukkan lokasi bimbingan"
                                        value="{{ old('location', $schedule->location) }}" required>
                                </div>

                                <!-- Kuota -->
                                <div class="mb-4">
                                    <label for="quota" class="form-label">
                                        <i class="fas fa-users me-2 text-primary"></i>Kuota
                                    </label>
                                    <input type="number" name="quota" id="quota" class="form-control"
                                        placeholder="Masukkan kuota peserta"
                                        value="{{ old('quota', $schedule->quota) }}" required>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Update Schedule
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<!-- Tambahkan style yang sama dari halaman create -->
<style>
    .form-label i {
        margin-right: 0.5rem;
    }

    .alert {
        margin-top: 1rem;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
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
```
