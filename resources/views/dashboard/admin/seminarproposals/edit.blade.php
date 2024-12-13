<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Edit Seminar Proposal">
    <x-navbars.sidebar activePage="review-sempro"></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Seminar Proposal"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-white mb-0">
                                        <i class="fas fa-edit me-2"></i>Edit Seminar Proposal
                                    </h2>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Atur jadwal dan detail seminar proposal mahasiswa
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('seminarproposals.update', $seminarproposal) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Student Info -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card bg-gray-100 shadow-none">
                                            <div class="card-body">
                                                <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">
                                                    Informasi Mahasiswa</h6>
                                                <p class="mb-1"><strong>Nama:</strong>
                                                    {{ $seminarproposal->mahasiswa->user->name }}</p>
                                                <p class="mb-0"><strong>NIM:</strong>
                                                    {{ $seminarproposal->mahasiswa->nim }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Schedule Details -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Seminar</label>
                                            <input type="date" name="date"
                                                class="form-control @error('date') is-invalid @enderror"
                                                value="{{ old('date', $seminarproposal->date) }}" required>
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Waktu Seminar</label>
                                            <input type="time" name="time"
                                                class="form-control @error('time') is-invalid @enderror"
                                                value="{{ old('time', $seminarproposal->time) }}" required>
                                            @error('time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Lokasi</label>
                                            <input type="text" name="location"
                                                class="form-control @error('location') is-invalid @enderror"
                                                value="{{ old('location', $seminarproposal->location) }}" required>
                                            @error('location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('seminarproposals.index') }}" class="btn btn-light me-2">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
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
