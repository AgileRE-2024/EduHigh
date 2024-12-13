<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Super Vision Page">
    <x-navbars.sidebar activePage='dosen-pembimbing'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Dosen Pembimbing"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <!-- Back Button -->
                    <a href="{{ route('supervisions.index') }}" class="btn btn-outline-primary mb-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>

                    <!-- Dosen Profile Card -->
                    <div class="card shadow-lg">
                        <!-- Card Header with Gradient Background -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex align-items-center">
                                <!-- Avatar -->
                                <div class="avatar avatar-xl bg-white text-primary rounded-circle me-3">
                                    <h4 class="mb-0">{{ strtoupper(substr($dosen->user->name, 0, 1)) }}</h4>
                                </div>
                                <!-- Dosen Name -->
                                <div>
                                    <h3 class="text-white mb-0">{{ $dosen->user->name }}</h3>
                                    <p class="text-white-50 mb-0">Bidang Keahlian: {{ $dosen->kbk->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6 mb-4">
                                    <div class="info-group mb-3">
                                        <i class="fas fa-id-card text-primary me-2"></i>
                                        <span>NIDN: {{ $dosen->nidn }}</span>
                                    </div>
                                    <div class="info-group mb-3">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <span>Email: {{ $dosen->user->email }}</span>
                                    </div>
                                    <div class="info-group mb-3">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        <span>No. Telp: {{ $dosen->user->phone }}</span>
                                    </div>
                                    <div class="info-group">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <span>Alamat: {{ $dosen->user->address }}</span>
                                    </div>
                                </div>
                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="info-group mb-3">
                                        <i class="fas fa-users text-primary me-2"></i>
                                        <span>Jumlah Mahasiswa Bimbingan: {{ $dosen->superVisions->count() }}</span>
                                    </div>
                                    <div class="info-group mb-3">
                                        <i class="fas fa-user-check text-primary me-2"></i>
                                        <span>Sedang Bimbingan:
                                            {{ $dosen->superVisions->where('status', 'approved')->count() }}</span>
                                    </div>
                                    <div class="info-group">
                                        <i class="fas fa-user-graduate text-primary me-2"></i>
                                        <span>Lulus:
                                            {{ $dosen->superVisions->where('status', 'completed')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer with Action Button -->
                        <div class="card-footer text-end">
                            @php
                                $existingSupervision = Auth::user()
                                    ->mahasiswa->superVisions->where('dosen_id', $dosen->id)
                                    ->first();
                            @endphp
                            @if (!$existingSupervision)
                                <form action="{{ route('supervisions.store') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="mahasiswa_id"
                                        value="{{ Auth::user()->mahasiswa->id }}">
                                    <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-user-plus me-2"></i>Ajukan Sebagai Pembimbing
                                    </button>
                                </form>
                            @elseif($existingSupervision->status == 'pending')
                                <button class="btn btn-secondary" disabled>
                                    <i class="fas fa-hourglass-half me-2"></i>Pengajuan Sedang Diproses
                                </button>
                            @else
                                <button class="btn btn-success" disabled>
                                    <i class="fas fa-check me-2"></i>Sudah Menjadi Pembimbing
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<!-- Additional Styling -->
@push('styles')
    <style>
        .avatar {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .info-group {
            font-size: 1rem;
            color: #344767;
        }

        .info-group i {
            width: 24px;
        }
    </style>
@endpush
